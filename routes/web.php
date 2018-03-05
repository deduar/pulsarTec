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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/home/profile', 'HomeController@editProfile')->name('edit_profile');

Route::get('/verify/{register_code}', 'HomeController@verify')->name('verify');

Route::get('/resend', 'HomeController@resend')->name('resend');

Route::get('/pay/{amt}/{lang}', 'HomeController@pay')->name('pay');

Route::get('/paypal_payment_response/{response}', 'HomeController@paypalpaymentresponse')->name('paypalPaymentResponse');
