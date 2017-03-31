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

Route::get('/', 'WebController@login');
Route::get('/gotoauthpage', 'WebController@goToAuthPage');
Route::get('/auth', 'WebController@auth');
Route::get('/success', 'WebController@success');
Route::get('/loginCancel', 'WebController@loginCancel');
Route::get('/sessionError', 'WebController@sessionError');
Route::get('/api/refreshToken', 'APIController@refreshToken');
Route::get('/api/verify', 'APIController@verify');
Route::get('/api/revoke', 'APIController@revoke');
