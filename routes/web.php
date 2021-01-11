<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'HomeController@main')->name('home')->middleware('FbAuth');
Route::POST('/save', 'HomeController@save')->name('save_profile')->middleware('FbAuth');
Route::get('/delete_contact', 'HomeController@delete_contact')->name('delete_contact')->middleware('FbAuth');
Route::get('/delete_profile', 'HomeController@delete_profile')->name('delete_profile')->middleware('FbAuth');

Route::get('/facebook/login', 'FacebookController@login')->name('FbLogin');
Route::get('/facebook/redirect', 'FacebookController@redirect')->name('FbRedirect');
Route::get('/facebook/callback', 'FacebookController@callback')->name('FbCallback');
Route::get('/facebook/logout', 'FacebookController@logout')->name('FbLogout')->middleware('FbAuth');
