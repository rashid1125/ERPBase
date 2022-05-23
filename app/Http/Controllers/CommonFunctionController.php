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

class CommonFunctionController extends Controller
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
     * _getQueryDynamicsView a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function _getQueryDynamicsView(Request $request)
    {
        try {
            $etype = $request->input('etype');
            $active = $request->input('active');
            $result = CommonFunctions::_getViewAllFromQueryBaseData($etype, $active);
            $query_dynamic = array();
            $fil = array();
            if ($result !== false) {
                foreach ($result as $query_dynamics) {
                    $queryDynamics = CommonFunctions::_getQueryDynamicsView($query_dynamics->query_dynamics_table_name, $query_dynamics->query_dynamics_column, $query_dynamics->query_dynamics_join, $query_dynamics->query_dynamics_where);
                    $fil['etype'] = $query_dynamics->etype;
                    $fil['status'] = $queryDynamics['status'];
                    $fil['message'] = $queryDynamics['message'];
                    $fil['data'] = $queryDynamics['data'];
                    $fil['error'] = $queryDynamics['error'];
                    array_push($query_dynamic, $fil);
                }
            }
            $response = $query_dynamic[0];
        } catch (\Throwable $th) {
            //throw $th;
            $response = CommonFunctions::getReturnResponse(false, 'An internal error occured while completing request. Please try again.', null, $th->getMessage());
        }
        return json_encode($response);
    }
}
