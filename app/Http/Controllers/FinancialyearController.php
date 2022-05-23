<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
// Models
use App\Models\CheckUserSession;
use App\Models\CommonFunctions;
use App\Models\Financialyear;
use App\Models\SettingConfigurations;


class FinancialyearController extends Controller
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

    public function index()
    {
        if (CommonFunctions::_getValidRoleGroupUserPermissions('vouchers', 'financialyearvoucher')) {
            $data['title'] = 'Financial Year';
            $data['currDate'] = date("F j, Y");
            $data['currDay'] = date("l");
            $data['wrapper_class'] = 'Financial Year';
            $data['etype'] = 'financialyearvoucher';
            $data['setting_configur'] = SettingConfigurations::all();
            $data['view_all_js'] = true;
            $data['modules'] = array('setup/addFinancialYear');
            $data['header'] = View::make('layouts.header', $data);
            $data['content'] = View::make('setup.addFinancialYear', $data);
            $data['mainnav'] = View::make('layouts.mainnav', $data);
            $data['footer'] = View::make('layouts.footer', $data);
            return View::make('layouts.default', $data);
        } else return View::make('layouts.page_404');
    }
    /**
     * FinancialyearSave a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function FinancialyearSave(Request $request)
    {
        try {
            $response = _getInsertedUpdatedDeletedRights('voucher_type_hidden'); // return response ture or false voucher rights
            if ((bool)$response['status'] == true && $response['data'] == null) {
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
            $response = CommonFunctions::getReturnResponse(false, 'An internal error occured while completing request. Please try again.', null, $th->getMessage());
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
            $response = Financialyear::_getVoucher($vrnoa);
            CommonFunctions::_getLogActivityDetail($vrnoa, 'financialyearvoucher', $response, 'Feched');
        } catch (\Throwable $th) {
            //throw $th;
            $response = CommonFunctions::getReturnResponse(false, 'An internal error occured while completing request. Please try again.', null, $th->getMessage());
        }
        return json_encode($response);
    }
}
