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

// Route::get('/', function () {
//     return view('frontend');
// });

Route::get('/', 'App\Http\Controllers\FrontendController@renderFrontend')->name('frontend');
// Route::any('/getOverlay', 'App\Http\Controllers\UserController@getOverlay');

// Route::middleware('logged_in')->get('/backoffice/login', 'App\Http\Controllers\BackofficeController@login')->name('login');

// Route::get('/backoffice', 'App\Http\Controllers\BackofficeController@home')->name('home');
// Route::get('/logout', 'App\Http\Controllers\BackofficeController@logout')->name('logout');

// Route::middleware('admin')->get('/backoffice/events', 'App\Http\Controllers\BackofficeController@events')->name('events');
// Route::middleware('admin')->get('/backoffice/packages', 'App\Http\Controllers\BackofficeController@packages')->name('packages');
// Route::middleware('admin')->get('/backoffice/users', 'App\Http\Controllers\BackofficeController@users')->name('users');

// Route::middleware('partner')->get('/backoffice/offers', 'App\Http\Controllers\BackofficeController@offers')->name('offers');

// Route::get('/backoffice/profile', 'App\Http\Controllers\BackofficeController@profile')->name('profile');