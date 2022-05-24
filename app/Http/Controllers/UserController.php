<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

// Models
use App\Models\CheckUserSession;
use App\Models\SettingConfigurations;
use App\Models\CommonFunctions;
use App\Models\Financialyear;
use App\Models\Rolegroups;
use App\Models\Users;



use Redirect;

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
     * Add New User
     * Form
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
     * UserSave a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function UserSave(Request $request)
    {
        try {
            $response = _getInsertedUpdatedDeletedRights('voucher_type_hidden'); // return response ture or false voucher rights
            if ((bool)$response['status'] == true && $response['data'] == null) {
                // Users::$primaryKey;
                $FinancialyearObject = json_decode($request->input('obj'), true);
                $voucher_type_hidden = $request->input('voucher_type_hidden');

                $response = Financialyear::IsAlreadyFinancialyearSaved($FinancialyearObject);

                if ($voucher_type_hidden === 'new') {
                    $FinancialyearObject['financialyear_id']  = Financialyear::max('financialyear_id') + 1;
                }

                if ((bool)$response['status'] == false && $response['data'] == null) {
                    $response = Financialyear::FinancialyearSave($FinancialyearObject);
                    CommonFunctions::_getLogActivityDetail($FinancialyearObject['financialyear_id'], 'financialyearvoucher', $FinancialyearObject, $voucher_type_hidden);
                }
            }
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
