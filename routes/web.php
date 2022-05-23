<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

use App\Http\Controllers\FinancialyearController;
use App\Models\Financialyear;
use Illuminate\Support\Facades\Route;
use App\Models\RouteDynamics;

/**
 * ========================================================================
 * login route's group please do not change any route if you change then do
 * work in these files like login.js, users model,AddVerificationEmail.js .
 * ========================================================================
 */
Route::get('getCSRF_token', 'WelcomeController@getCSRF_token');

Route::get('/', 'WelcomeController@index');

Route::get('login', 'WelcomeController@index')->name('login');

Route::post('userlogin', 'WelcomeController@getAuthentication');

Route::get('verificationemail', 'WelcomeController@getLoadVerificationEMail');

Route::post('getValidateUserOTPCode', 'WelcomeController@getValidateUserOTPCode');

Route::post('user/logout', 'UserController@logOut');

try {

    $RouteDynamics =  RouteDynamics::all();
    if (count($RouteDynamics) > 0)
        foreach ($RouteDynamics as $key => $routedynamic) {
            if ($routedynamic['function_method'] == 'get')
                Route::get($routedynamic['slug'], $routedynamic['controller_name'] . '@' . $routedynamic['function_name']);
            else if ($routedynamic['function_method'] == 'post')
                Route::post($routedynamic['slug'], $routedynamic['controller_name'] . '@' . $routedynamic['function_name']);
        }
} catch (\Throwable $th) {
    //throw $th;
    echo '*************************************' . PHP_EOL;
    echo 'Error fetching database pages: ' . PHP_EOL;
    echo $th->getMessage() . PHP_EOL;
    echo '*************************************' . PHP_EOL;
}


Route::post('voucher/setupviewall', 'CommonFunctionController@_getQueryDynamicsView');

Route::post('OptionCallComponent/getroleGroupOption', 'CommonFunctionController@_getroleGroupOption');
Route::post('OptionCallComponent/getCompanyOption', 'CommonFunctionController@_getCompanyOption');
// All Post Request Write down for clear understanding!.

// Financial Year Route
Route::post('financialyear/financialyearsave', 'FinancialyearController@FinancialyearSave');
Route::post('financialyear/getVoucher', 'FinancialyearController@_getVoucher');
