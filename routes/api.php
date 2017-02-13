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

/* All users */
Route::post('/login', 'UserController@login');
Route::any('/facebookLogin', 'UserController@facebookLogin');
Route::any('/oAuthRedirect', 'UserController@oAuthRedirect');

/* Admin Routes */
Route::post('/addEditPackage', 'PackageController@addEditPackage');
Route::get('/getPackages', 'PackageController@getPackages');
Route::get('/getPackageById', 'PackageController@getPackageById');

Route::post('/addPartnerAccount', 'UserController@addPartnerAccount');
Route::any('/getAvatar/{id}', 'UserController@getAvatar');
Route::post('/changeAvatar', 'UserController@changeAvatar');
Route::post('/changePassword', 'UserController@changePassword');
Route::post('/resetPartnerPassword', 'UserController@resetPartnerPassword');
Route::get('/getUsers', 'UserController@getUsers');

Route::post('/addEditEvent', 'EventController@addEditEvent');
Route::get('/getEvents', 'EventController@getEvents');
Route::get('/getEventById', 'EventController@getEventById');
Route::get('/getEventRegistrations', 'EventController@getEventRegistrations');
Route::post('/registerForEvent', 'EventController@registerForEvent');

Route::post('/addEditOffer', 'OfferController@addEditOffer');
Route::get('/getOffers', 'OfferController@getOffers');
Route::get('/getOfferById', 'OfferController@getOfferById');
Route::get('/getOfferApplications', 'OfferController@getOfferApplications');
Route::post('/applyForOffer', 'OfferController@applyForOffer');
Route::get('/downloadApplication/{id_application}', 'OfferController@downloadApplication');
