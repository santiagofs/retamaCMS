<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/', function(Request $request) {
    $laravel = app();
    return response()->json(['api-version'=> '1.0.0', 'laravel-version' => $laravel::VERSION]);
});

// Route::post('register', 'AuthController@register');
// Route::post('login', 'AuthController@login');
// Route::post('recover', 'AuthController@recover');

// Route::group(['middleware' => ['jwt.auth']], function() {
//     Route::get('logout', 'AuthController@logout');
// });


Route::get('settings', function(Request $request) {
    $base = array_dot(\Config::get('retamaBack'));

    $front = array_dot(\Config::get('retamaFront'));

    foreach($front as $key => $value) {
        $base[$key] = $value;
    }

    $site = array_dot(\Config::get('retama'));
    foreach($site as $key => $value) {
        $base[$key] = $value;
    }
    $ret = [];
    foreach($base as $key => $value) {
        array_set($ret, $key, $value);
    }
    return response()->json($ret);

});

Route::post('settings', function(Request $request) {

});

// Authentication routes with JW Token
require_once('partials/jwt.php');
require_once('partials/users.php');
require_once('partials/admins.php');