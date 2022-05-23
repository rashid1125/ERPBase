<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CheckUserSession;
use App\Models\SettingConfigurations;
use App\Models\Users;
use App\Models\DatabaseBackUp;
use App\Models\Items;
use App\Models\Companies;
use App\Models\Departments;
use App\Models\Accounts;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

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
    public function index()
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

    public function logOut()
    {
        Session::flush();
        return redirect()->intended('/login');
    }
}
