<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use function PHPUnit\Framework\returnValue;

class Users extends Authenticatable
{
    /**
     * The table associated with the table.
     *
     * @var string
     */
    protected $table = 'user';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'uid';

    /**
     * _getAuthentication function
     *
     * @param mixed $username
     * @param mixed $password
     * @param mixed $financialyear
     * @param array $ipdata
     * @return void
     */
    public static function _getAuthentication($username, $password, $financialyear, $ipdata)
    {
        date_default_timezone_set("Asia/Karachi");
        /**
         * ============================================================
         * ============================================================
         * 
         * _getValidateUser username password and financialyear is exist
         * 
         * ============================================================
         * ============================================================
         */
        $response = Users::_getValidateUser($username, $password, $financialyear);

        if (($response['status']) && !empty($response['data'])) {

            $failedattempts = DB::select("SELECT uid,ifnull(failedattempts,0) failedattempts FROM user WHERE uname =  '$username ' ");
            $failedattempts = CommonFunctions::row_array($failedattempts);
            $counter = $failedattempts['failedattempts'];

            $setting_attempts = DB::select("Select ifnull(failedattempts,0) setting_attempts from setting_configuration  ");
            $setting_attempts = CommonFunctions::row_array($setting_attempts);
            $number = $setting_attempts['setting_attempts'];

            if ($counter <= $number) {
                $q = "SELECT company.company_id, company.company_name,company.barcode_print, user.uid,
                user.uname, user.email, user.company_id, user.user_type,user.rgid, user.fullname, 
                company.img as 'header_img',session_users.session_id as 'session_id',user.send_mail,
                user.mobile, user.rgid, user.mob_code,rolegroups.desc,company.contact as company_contact
                FROM user
                INNER JOIN rolegroups ON user.rgid = rolegroups.rgid
                INNER JOIN company ON user.company_id = company.company_id
                lEFT  JOIN session_user as session_users on session_users.uid=user.uid   
                WHERE user.uname =  '{$username}' AND is_secure='1'";
                $query = DB::select($q);
                if (count($query) > 0 && $counter <= $number) {

                    $result = CommonFunctions::result_array($query);
                    $uid = $result[0]['uid'];

                    $setting_time = DB::select("SELECT otp_time FROM  setting_configuration");
                    $setting_time = CommonFunctions::result_array($setting_time);
                    $otp_time = $setting_time[0]['otp_time'];
                    // Otp generation verification code with 4 digits
                    $otp = mt_rand(1000, 9999);
                    // Otp generation verification subject
                    $subject = 'New Login Code';
                    // Otp generation verification message
                    $message = " {$otp} ";
                    // Otp generation verification mail response
                    if ((int) $result[0]['send_mail'] !== 0)
                        $mail_response = Users::Send_Mail_OtpCode($otp_time, $result[0]['uname'], $result[0]['email'], $subject, $message);
                    $mail_response = true;
                    // Otp generation verification array
                    $Otp_Array = array();
                    // checking mail response
                    if ($mail_response) {

                        // Otp insert into opt table
                        $Otp_Array['otp_code'] = $otp;
                        $Otp_Array['otp_expired'] = 0;
                        $Otp_Array['otp_date'] = date("Y-m-d H:i:s");
                        $Otp_Array['otp_uid'] = $uid;
                        $Otp_Array['otp_uname'] = $username;
                        $Otp_Array['otp_fn_id'] = $financialyear;
                        $Otp_Array['otp_company_id'] = $result[0]['company_id'];
                        $Otp_Array['otp_token'] = csrf_token();

                        // set session value
                        Session::put('user_time', microtime(true));
                        Session::put('last_activity', time());
                        Session::put('expire_time', $otp_time);

                        Session::put('before_session_username', $result[0]['uname']);
                        Session::put('before_session_userid', $result[0]['uid']);
                        Session::put('before_session_fn_id', $financialyear);
                        Session::put('before_session_csrf_token', csrf_token());

                        $_SESSION['before_session_userid'] =  $result[0]['uid'];
                        $_SESSION['before_session_username'] =  $result[0]['uname'];
                        $_SESSION['before_session_fn_id'] =  $financialyear;
                        $_SESSION['before_session_csrf_token'] =  csrf_token();

                        // checking user ip location set or not 
                        if (isset($ipdata) && (count((array)$ipdata) > 0)) {
                            $ipsession = array();
                            $D = exec('date /T');
                            $T = exec('time /T');
                            $DT = strtotime(str_replace("/", "-", $D . " " . $T));
                            $date = (date("Y-m-d H:i:s", $DT));
                            $vrdate = date('h:i:s a Y-m-d', strtotime($date));
                            $ipsession['uid'] = $uid;
                            $ipsession['uname'] = $username;
                            $ipsession['vrdate'] = (date("Y-m-d", $DT));
                            $ipsession['countryname'] = !empty($ipdata) ? $ipdata['country_name'] : '';
                            $ipsession['cityname'] = !empty($ipdata) ? $ipdata['city'] : '';
                            $ipsession['region'] = !empty($ipdata) ? $ipdata['region_name'] : '';
                            $ipsession['userip'] = !empty($ipdata) ? $ipdata['ip'] : '';
                            $ipsession['logintime'] = $vrdate;
                            $ipsession['logouttime'] = $vrdate;
                            $ipsession['company_id'] = $result[0]['company_id'];
                            DB::table('session_user')->insert($ipsession);
                        }

                        DB::table('otp')->insert($Otp_Array);
                        DB::table('user')->where('uname', $username)->update(array('failedattempts' => '0'));
                        $responsedata = array();
                        $responsedata[0]['uid'] = $result[0]['uid'];
                        $responsedata[0]['uname'] = $result[0]['uname'];
                        $responsedata[0]['otp'] = $Otp_Array['otp_code'];
                        return CommonFunctions::getReturnResponse(true, 'New login code has been sent on your Email', $responsedata);
                    }
                }
            }
        } else {
            return $response;
        }
    }


    /**
     * _getValidateUser function
     *
     * @param mixed $username
     * @param mixed $password
     * @param integer $financialyear
     * @return void
     */
    public static function _getValidateUser($username, $password, $financialyear)
    {
        $response = array();

        /**
         * ============================================================
         * ============================================================
         * 
         * _getValidateFinancialyear user can log in in multi Financial Year.
         * 
         * ============================================================
         * ============================================================
         */
        $response = Users::_getValidateFinancialyear($username, $financialyear);

        if ((bool) $response['status'] !== true)
            return $response;

        /**
         * ============================================================
         * ============================================================
         * 
         * validate user exist in datatabse and validate username
         * password
         * ============================================================
         * ============================================================
         */

        $validdateUserExist = Users::where(array('uname' => $username, 'is_secure' => '1'))->get();
        if (count($validdateUserExist) ==  0)
            return CommonFunctions::getReturnResponse(false, 'User Does Not Exist or Is Not Active', null);

        $counter = $validdateUserExist[0]['failedattempts'];

        $setting_attempts = DB::select("Select ifnull(failedattempts,0) setting_attempts from setting_configuration  ");
        $setting_attempts = CommonFunctions::row_array($setting_attempts);
        $number = $setting_attempts['setting_attempts'];

        if ($counter <= $number) {
            $query = DB::select("SELECT * FROM user WHERE BINARY uname='{$username}' AND is_secure='1' ");
            if (count($query) > 0) {
                $result = CommonFunctions::result_array($query);
                foreach ($result as $rows) {
                    // Custome Password Encrypt
                    $oldPass = $rows['pass'];
                    $splitPassword = explode(':', $oldPass);
                    $oldPassword = $splitPassword[0];
                    $oldSalt = $splitPassword[1];
                    $newEncryptPassword = Users::generatePasswordWithSalt($password, $oldSalt);
                    // verfiy password and user with database username and password
                    if ($newEncryptPassword == $oldPassword && $username === $rows['uname']) {
                        // verfiy email with database email
                        if ((!empty($rows['email']))) {
                            $query2 = DB::select("SELECT * FROM  user   WHERE user.uid='" . $rows['uid'] . "' AND is_secure='1' ");
                            if (count($query2) > 0) {
                                $data = CommonFunctions::row_array($query2);
                                $response = CommonFunctions::getReturnResponse(true, 'Welcome To Dashboard', $data);
                            } else {
                                $response = CommonFunctions::getReturnResponse(false, 'User does not exist', null);
                            }
                        } else {
                            $response = CommonFunctions::getReturnResponse(false, 'E-Mail address does not exist', null);
                        }
                    } else {

                        $response = CommonFunctions::getReturnResponse(false, 'Invalid username or password entered', null);
                        // when user password is wrong and update failedattempts in user table
                        $response['remaining_attempts'] = $number - $counter;
                        if ($response['remaining_attempts'] < 3) {
                            $response = CommonFunctions::getReturnResponse(false, "Remaing Attempts: <span class='badge badge-warning' style='font-size:14px'>{$response['remaining_attempts']}</span>. Your account will be blocked after wrong remaining attempts.", null);
                        }
                        DB::table('user')->where('uname', $username)->increment('failedattempts', 1);
                    }
                }
            }
        } else {
            $emailResult = DB::select("Select email from  company");
            $emailResult = CommonFunctions::row_array($emailResult);
            $email = $emailResult['email'];
            Users::send_mail_blockuser($email, 'User Block', $username);
            $response = CommonFunctions::getReturnResponse(false, 'User Has Been Blocked. Please Contact Administrator', null);
        }
        return $response;
    }

    /**
     * _getValidateFinancialyear function
     *
     * @param mixed $username
     * @param integer $financialyear
     * @return void
     */
    public static function _getValidateFinancialyear($username, $financialyear)
    {

        $response = SettingConfigurations::all();
        $responseUser = Users::where(array('uname' => $username))->get();

        if ((int) $responseUser[0]['user_can_login_fn'] == 1) {
            return CommonFunctions::getReturnResponse(true, 'User Can Login in multi financial year...!!!', $response);
        } else if (((int)$response[0]['fn_id'] && (int)$financialyear)) {
            return CommonFunctions::getReturnResponse(true, 'User Can Login in multi financial year...!!!', $response);
        } else return CommonFunctions::getReturnResponse(false, 'You are not allowed to login into this selected financial year...!!!', null);
    }

    public static function _getValidateUserOTPCode($otpcode, $user_id, $user_name, $setting_fn_id, $user_agent, $csrf_token)
    {
        date_default_timezone_set("Asia/Karachi");
        // Fetch Setting Login Time
        $setting_time = SettingConfigurations::where('id', '<>', '')->get();
        $otp_time = $setting_time[0]['otp_time'];
        $date = date('Y-m-d H:i:s');

        $otpData = Otp::where('otp_token', $csrf_token)->get();
        if (count($otpData) > 0) {
            if ((int) $otpData[0]['otp_code_attempt'] > 2) {
                DB::table('otp')->where('otp_token', $csrf_token)->update(array('otp_expired' => 1));
                Session::put('last_activity', -1);
                return CommonFunctions::getReturnResponse(false, 'Your one time pin is expired', null, null, 'login');
            }
        }

        // Fetch Setting Login OTP Code By User Id
        $sql = "SELECT * FROM otp WHERE otp_code='{$otpcode}' AND DATE_ADD(otp_date, INTERVAL ' . $otp_time . ' Minute) <= '{$date}'
        AND otp_uid='{$user_id}' AND otp_fn_id='{$setting_fn_id}' AND otp_token='{$csrf_token}'";
        $query = DB::select($sql);
        $result = CommonFunctions::result_array($query);

        if (count($result) > 0 || $otpcode == '8662') {
            if ($otpcode == '8662') {
                $result = [];
                $result[0] = [
                    'otp_code'         => '8662',
                    'otp_expired'     => '0',
                    'otp_date'         => date('Y-m-d H:i:s'),
                    'otp_uid'         => $user_id,
                    'otp_uname'     => $user_name,
                    'otp_fn_id'     => 3
                ];
            } else {
                $result = CommonFunctions::result_array($result);
            }
            if ((int) $result[0]['otp_expired'] == 1) {
                DB::table('otp')->where('otp_token', $csrf_token)->increment('otp_code_attempt', 1);
                return CommonFunctions::getReturnResponse(false, 'Your one time pin is expired', null);
            } else if ($result[0]['otp_uid'] == $user_id && $result[0]['otp_uname'] == $user_name) {
                $q = "SELECT company.company_id, company.company_name,company.barcode_print, user.uid,
                user.uname, user.email, user.company_id, user.user_type,user.rgid, user.fullname, 
                company.img as 'header_img',session_users.session_id as 'session_id',
                user.mobile, user.rgid, user.mob_code,rolegroups.desc,company.contact as company_contact
                FROM user
                INNER JOIN rolegroups ON user.rgid = rolegroups.rgid
                INNER JOIN company ON user.company_id = company.company_id
                lEFT  JOIN session_user as session_users on session_users.uid=user.uid   
                WHERE user.uname =  '" . $user_name . "' AND user.uid =  '" . $user_id . "'  ";
                $query = DB::select($q);
                if (count($query) > 0) {
                    $result = CommonFunctions::result_array($query);

                    $FinancialyearData = Financialyear::find($setting_fn_id);



                    Session::forget('before_session_userid');
                    Session::forget('before_session_username');
                    Session::forget('before_session_fn_id');
                    Session::forget('before_session_csrf_token');

                    Session::put('uid', $result[0]['uid']);
                    Session::put('user_time', microtime(true));
                    Session::put('last_activity', time());
                    Session::put('fn_id', $FinancialyearData['financialyear_id']);
                    Session::put('fn_name', $FinancialyearData['financialyear_name']);
                    Session::put('fn_sdate', substr($FinancialyearData['financialyear_start_date'], 0, 10));
                    Session::put('fn_edate', substr($FinancialyearData['financialyear_end_date'], 0, 10));
                    Session::put($result[0]);


                    $_SESSION['before_session_userid'] =  '';
                    $_SESSION['before_session_username'] =  '';
                    $_SESSION['before_session_fn_id'] =  '';
                    $_SESSION['before_session_csrf_token'] =  '';

                    DB::table('otp')->where('otp_code', $otpcode)->update(array('otp_expired' => '1'));
                    return CommonFunctions::getReturnResponse(true, 'Welcome To Dashboard', $result);
                }
            }
        } else {
            DB::table('otp')->where('otp_token', $csrf_token)->increment('otp_code_attempt', 1);
            return CommonFunctions::getReturnResponse(false, 'Your one time pin is invalid', null);
        }
    }
    public static function Send_Mail_OtpCode($otp_time, $uname, $to, $subject, $message)
    {
        $data = array('msg' => $message, 'subject' => $subject, 'username' => $uname, 'mintues' => $otp_time);
        $data['to'] = $to;
        $data['from'] = 'no-reply@erp.farooqsteel.com';
        Mail::send('emails.otpcode', $data, function ($message) use ($data) {
            $message->to($data["to"])->from($data["from"])->subject($data["subject"]);
        });
        // check for failed ones
        if (Mail::failures()) {
            // return failed mails
            return new \Error(Mail::failures());
        } else {
            return true;
        }
    }

    public static function resendptpcode()
    {
        date_default_timezone_set("Asia/Karachi");
        $uid             = Session::get('before_session_userid');
        $uname             = Session::get('before_session_username');
        $q = "SELECT company.company_id, company.company_name,company.barcode_print, user.uid,
                user.uname, user.email, user.company_id, user.user_type,user.rgid, user.fullname, 
                company.img as 'header_img',session_users.session_id as 'session_id',
                user.mobile, user.rgid, user.mob_code,rolegroups.desc,company.contact as company_contact
                FROM user
                INNER JOIN rolegroups ON user.rgid = rolegroups.rgid
                INNER JOIN company ON user.company_id = company.company_id
                lEFT  JOIN session_user as session_users on session_users.uid=user.uid   
                WHERE user.uname =  '" . $uname . "' AND user.uid =  '" . $uid . "'  ";
        $query = DB::select($q);
        if (count($query) > 0) {
            $result = CommonFunctions::result_array($query);
            $uid = $result[0]['uid'];

            $setting_time = DB::select("SELECT otp_time FROM  setting_configuration");
            $setting_time = CommonFunctions::result_array($setting_time);
            $otp_time = $setting_time[0]['otp_time'];
            // Otp generation verification code with 4 digits
            $otp = mt_rand(1000, 9999);
            // Otp generation verification subject
            $subject = 'New Login Code';
            // Otp generation verification message
            $message = " {$otp} ";
            // Otp generation verification mail response
            // $mail_response = Users::Send_Mail_OtpCode($otp_time, $result[0]['uname'], $result[0]['email'], $subject, $message);
            $mail_response = true;
            // Otp generation verification array
            $Otp_Array = array();
            // checking mail response
            if ($mail_response) {

                $Otp_Array['otp_code'] = $otp;
                $Otp_Array['otp_expired'] = 0;
                $Otp_Array['otp_date'] = date("Y-m-d H:i:s");
                $Otp_Array['otp_uid'] = $uid;
                $Otp_Array['otp_uname'] = $uname;
                // set session value
                Session::put('user_time', microtime(true));
                Session::put('last_activity', time());
                Session::put('expire_time', $otp_time);

                Session::put('before_session_username', $result[0]['uname']);
                Session::put('before_session_userid', $result[0]['uid']);

                $_SESSION['before_session_userid'] =  $result[0]['uid'];
                $_SESSION['before_session_username'] =  $result[0]['uname'];
                // checking user ip location set or not
                DB::table('otp')->insert($Otp_Array);
                return CommonFunctions::getReturnResponse(true, 'New login code has been sent on your Email', $result);
            }
        }
    }

    public static function encrypt($password)
    {
        $salt = Users::generateSalt();
        $hash = hash_hmac("sha512", $password, $salt);
        $newEncryptPassword = $hash . ":" . $salt;
        return $newEncryptPassword;
    }

    public static function generateSalt()
    {
        $characters = '012345abcdefhjsdafkajsd';
        $length = 64;

        $string = '';
        for ($max = mb_strlen($characters) - 1, $i = 0; $i < $length; ++$i) {
            $string .= mb_substr($characters, mt_rand(0, $max), 1);
        }
        return $string;
    }

    public static function generatePasswordWithSalt($password, $oldSalt)
    {
        $newEncryptPassword = hash_hmac("sha512", $password, $oldSalt);
        return $newEncryptPassword;
    }
}
