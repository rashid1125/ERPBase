<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CommonFunctions;
use Redirect;
use App\Models\SettingConfigurations;
use App\Models\Users;
use App\Models\Financialyear;
use app\Models\Otp;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Input;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Session::get('uname') != null) {
                return redirect()->intended('/user/dashboard');
            } else {
                return $next($request);
            }
        });
    }

    public function index()
    {
        $data['setting'] = SettingConfigurations::fetch();
        // Redirect user if logged in.

        // LoginHelper::auth_secure();
        $t = Session::get('last_activity');
        // die(print_r(Session::all()));
        if (Session::has('last_activity')) {
            // Chekcing if security code exprie or not?
            $t = Session::get('last_activity');
            if (time() >= $t + ($data['setting'][0]['otp_time'] * 60)) {
                // if 5 minutes elapsed then destroy all session.
                Session::flush();
            }
        }
        $data['financialyears'] = Financialyear::all();
        $data['errors'] = Input::get('submit') ? true : false;
        $data['modules'] = array('auth/login');
        $data['wrapper_class'] = 'login';
        $data['header'] = View::make('layouts.loginheader', $data);
        $data['footer'] = View::make('layouts.loginfooter', $data);
        return View::make('auth.login', $data);
    }

    /**
     * Store a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAuthentication(Request $request)
    {
        try {
            $username = $request->input('user_name');
            $password = $request->input('user_pass');
            $ipdata = $request->input('logindata');
            $user_agent = $request->input('user_agent');
            $financialyear = $request->input('financialyear');
            $response = Users::_getAuthentication($username, $password, $financialyear, $ipdata);
            if ($response['status']) {
                Auth::loginUsingId($response['data'][0]['uid']);
            }
        } catch (\Throwable $th) {
            //throw $th;
            $response = CommonFunctions::_getReturnResponse(false, 'An internal error occured while completing request. Please try again.', null, $th->getMessage());
        }
        return json_encode($response);
    }


    public function getLoadVerificationEMail()
    {
        if (Session::has('before_session_userid')) {
            $data['setting'] = SettingConfigurations::all();
            $data['errors'] = isset($_POST['submit']) ? true : false;
            $data['wrapper_class'] = 'VerificationEmail';
            $data['modules'] = array('auth/AddVerificationEmail');
            $data['title'] = 'Verification Code';
            $data['header'] = View::make('layouts.loginheader', $data);
            $data['footer'] = View::make('layouts.loginfooter', $data);
            return View::make('auth.AddVerificationEmail', $data);
        } else {
            return redirect()->intended('/user/dashboard');
        }
    }

    /**
     * Store a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getValidateUserOTPCode(Request $request)
    {
        // Redirect user if logged in.=
        try {
            $user_id = $request->input('uid');
            $user_name = $request->input('uname');
            $financialyear_id = $request->input('fn_id');
            $otpcode =  $request->input('code');
            $user_agent = $request->input('user_agent');
            $csrf_token = csrf_token();
            $response = Users::_getValidateUserOTPCode($otpcode, $user_id, $user_name, $financialyear_id, $user_agent, $csrf_token);
        } catch (\Throwable $th) {
            //throw $th;
            $response = CommonFunctions::_getReturnResponse(false, 'An internal error occured while completing request. Please try again.', null, $th->getMessage());
        }
        return json_encode($response);
    }
    public function getCSRF_token()
    {
        return csrf_token();
    }
}
