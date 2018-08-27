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

Route::get('setLocale/{locale}', function($locale){
	Session::put('_locale', $locale);
	App::setLocale($locale);
	return back();
})->name('setLocale');

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/profile', 'HomeController@editProfile')->name('edit_profile');

Route::get('/verify/{register_code}', 'HomeController@verify')->name('verify');

Route::get('/resend', 'HomeController@resend')->name('resend');

Route::get('/pay/{amt}/{lang}', 'HomeController@pay')->name('pay');
Route::get('/pay_renew', 'HomeController@payRenew')->name('pay_renew');
Route::get('/paypal_payment_response/{response}', 'HomeController@paypalpaymentresponse')->name('paypalPaymentResponse');

// Profile
Route::post('/update', 'HomeController@updateProfile')->name('update_profile');
Route::get('/change_password', 'HomeController@changePassword')->name('change_password');
Route::post('/update_password', 'HomeController@updatePassword')->name('update_password');

// temporal routes, testing cron
Route::get('/testByDue', 'HomeController@testByDue')->name('testByDue');
Route::get('/testByEnding', 'HomeController@testByEnding')->name('testByEnding');
