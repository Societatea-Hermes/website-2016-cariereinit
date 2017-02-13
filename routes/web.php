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

Route::middleware('logged_in')->get('/backoffice/login', 'BackofficeController@login')->name('login');

Route::get('/backoffice', 'BackofficeController@home')->name('home');
Route::get('/logout', 'BackofficeController@logout')->name('logout');

Route::middleware('admin')->get('/backoffice/events', 'BackofficeController@events')->name('events');
Route::middleware('admin')->get('/backoffice/packages', 'BackofficeController@packages')->name('packages');
Route::middleware('admin')->get('/backoffice/users', 'BackofficeController@users')->name('users');

Route::middleware('partner')->get('/backoffice/offers', 'BackofficeController@offers')->name('offers');

Route::get('/backoffice/profile', 'BackofficeController@profile')->name('profile');
