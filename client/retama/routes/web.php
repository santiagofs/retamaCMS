<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// exit();
$prefix = '';

// $prefix = Language::url_prefix();
// \App::setLocale(\Language::current()->laravel_prefix);
// setlocale(LC_ALL,\Language::current()->i18n);
// \Language::translate();





Route::group(array('prefix' => $prefix), function() use($prefix) {
    // var_dump($prefix);
});