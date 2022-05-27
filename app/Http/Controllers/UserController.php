<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
// Models
use App\Models\CheckUserSession;
use App\Models\SettingConfigurations;
use App\Models\CommonFunctions;
use App\Models\Users;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $time = time();
            if (CheckUserSession::check(Session::all())) {
                $request->session()->put('last_activity', $time);
                return $next($request);
            }
            return redirect()->intended('/login');
        });
    }

    /**
     * index User
     * @return void
     */
    public function index()
    {
        if (CommonFunctions::_getValidRoleGroupUserPermissions('vouchers', 'uservoucher')) {
            $data['title'] = 'User';
            $data['currDate'] = date("F j, Y");
            $data['currDay'] = date("l");
            $data['wrapper_class'] = 'User';
            $data['etype'] = 'uservoucher';
            $data['setting_configur'] = SettingConfigurations::all();
            $data['view_all_js'] = true;
            $data['modules'] = array('setup/AddUserVoucher');
            $data['header'] = View::make('layouts.header', $data);
            $data['content'] = View::make('setup.AddUserVoucher', $data);
            $data['mainnav'] = View::make('layouts.mainnav', $data);
            $data['footer'] = View::make('layouts.footer', $data);
            return View::make('layouts.default', $data);
        } else return View::make('layouts.page_404');
    }

    /**
     * dashboard function
     *
     * @return void
     */
    public function dashboard()
    {
        $data['title'] = 'Dashboard';
        $data['currDate'] = date("F j, Y");
        $data['currDay'] = date("l");
        $data['wrapper_class'] = 'dashboard';
        $data['setting_configur'] = SettingConfigurations::all();
        $data['modules'] = array('auth/dashboard');
        $data['header'] = View::make('layouts.header', $data);
        $data['content'] = View::make('auth.dashboard', $data);
        $data['mainnav'] = View::make('layouts.mainnav', $data);
        $data['footer'] = View::make('layouts.footer', $data);
        return View::make('layouts.default', $data);
    }


    /**
     * userSave a new method.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function userSave(Request $request)
    {
        try {

            $_POST['etype'] = 'uservoucher';  // this is etype used  for rigths
            $_POST['voucher_type_hidden'] = 'new'; // this is voucher_type_hidden used  for rigths

            $response = _getInsertedUpdatedDeletedRights('voucher_type_hidden'); // return response ture or false voucher rights

            if ((bool)$response['status'] == true && $response['data'] == null) {

                /**
                 * creating an object to save user data object into the user table.
                 */

                $requestUser = new Users();
                $requestUser->date = $request['date'];
                $requestUser->uname = $request['uname'];
                $requestUser->fullname = $request['fullname'];
                $requestUser->email = $request['email'];
                $requestUser->mobile = $request['mobile'];
                $requestUser->rgid = $request['rgid'];
                $requestUser->user_can_login_fn = $request['user_can_login_fn'];
                $requestUser->level3_id = $request['level3_id'];
                $requestUser->is_secure = ($request['is_secure']) ? $request['is_secure'] : 1;
                $requestUser->report_to_user = $request['report_to_user'];
                $requestUser->company_id = ($request['company_id']) ? $request['company_id'] : Session::get('company_id');
                $requestUser->uuid = ($request['uid']) ? $request['uid'] : Session::get('uid');

                // Form Validation
                $validator = Validator::make($request->all(), Users::Rules($request['uname']), Users::RulesMessage());

                $response_error = [];

                if ($validator->fails()) {
                    foreach ($validator->errors()->all() as $key => $error) :
                        $response_error[$key] = $error . '<br />';

                    endforeach;
                    $response = CommonFunctions::_getReturnResponse(false, str_replace(',', '', $response_error), null);
                }

                if ($request->hasFile('photo')) {
                    $photo = $request->file('photo')->getClientOriginalName();
                    $destination = base_path() . '/assets/upload_img/user';
                    $request->file('photo')->move($destination, $photo);
                    $requestUser->photo = $request['photo'];
                }

                if (!($validator->fails())) {
                    $requestUser->save();

                    $status = Password::sendResetLink($request->only('email'));
                    $status === Password::RESET_LINK_SENT ? $status : '';

                    $response = CommonFunctions::_getReturnResponse(true, 'User saved successfully', $_POST);
                }

                CommonFunctions::_getLogActivityDetail($requestUser['uid'], $_POST['etype'], $requestUser, $_POST['voucher_type_hidden']);
            }
        } catch (\Throwable $th) {
            //throw $th;
            $response = CommonFunctions::_getReturnResponse(false, 'An internal error occured while completing request. Please try again.', null, $th->getMessage());
        }
        return json_encode($response);
    }
    /**
     * userUpdate a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function userUpdate(Request $request)
    {
        try {

            $_POST['etype'] = 'uservoucher';  // this is etype used  for rigths
            $_POST['voucher_type_hidden'] = 'edit'; // this is voucher_type_hidden used  for rigths
            $response = _getInsertedUpdatedDeletedRights('voucher_type_hidden'); // return response ture or false voucher rights
            if ((bool)$response['status'] == true && $response['data'] == null) {
                /**
                 * creating an object to save user data object into the user table.
                 */

                $requestUser = new Users();
                $requestUser->date = $request['date'];
                $requestUser->uname = $request['uname'];
                $requestUser->fullname = $request['fullname'];
                $requestUser->email = $request['email'];
                $requestUser->mobile = $request['mobile'];
                $requestUser->rgid = $request['rgid'];
                $requestUser->company_id = $request['company_id'];
                $requestUser->user_can_login_fn = $request['user_can_login_fn'];
                $requestUser->level3_id = $request['level3_id'];
                $requestUser->is_secure = $request['is_secure'];
                $requestUser->report_to_user = $request['report_to_user'];
                $requestUser->uuid = ($request['uid']) ? $request['uid'] : Session::get('uid');

                // Form Validation
                $validator = Validator::make($request->all(), Users::Rules($request['uid']), Users::RulesMessage());

                $response_error = [];

                if ($validator->fails()) {
                    foreach ($validator->errors()->all() as $key => $error) :
                        $response_error[$key] = $error . '<br />';

                    endforeach;
                    $response = CommonFunctions::_getReturnResponse(false, str_replace(',', '', $response_error), null);
                }

                if ($request->hasFile('photo')) {
                    $photo = $request->file('photo')->getClientOriginalName();
                    $destination = base_path() . '/assets/upload_img/user';
                    $request->file('photo')->move($destination, $photo);
                    $requestUser->photo = $request['photo'];
                }

                if (!($validator->fails())) {
                    $requestUser->exists = true;
                    $requestUser->uid = $request['uid'];
                    $requestUser->save();
                    $response = CommonFunctions::_getReturnResponse(true, 'User update successfully', $_POST);
                }

                CommonFunctions::_getLogActivityDetail($requestUser['uid'], $_POST['etype'], $requestUser, $_POST['voucher_type_hidden']);
            }
        } catch (\Throwable $th) {
            //throw $th;
            $response = CommonFunctions::_getReturnResponse(false, 'An internal error occured while completing request. Please try again.', null, $th->getMessage());
        }
        return json_encode($response);
    }

    /**
     * _getVoucher a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function _getVoucher(Request $request)
    {
        try {
            $vrnoa = $request->input('vrnoa');
            $response = Users::_getVoucher($vrnoa);
            CommonFunctions::_getLogActivityDetail($vrnoa, 'uservoucher', $response, 'Feched');
        } catch (\Throwable $th) {
            //throw $th;
            $response = CommonFunctions::_getReturnResponse(false, 'An internal error occured while completing request. Please try again.', null, $th->getMessage());
        }
        return json_encode($response);
    }

    /**
     * logOut function
     * User logout and flash session
     * @return void
     */
    public function logOut()
    {
        Session::flush();
        return redirect()->intended('/login');
    }
}
