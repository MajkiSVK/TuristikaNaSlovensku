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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/facebook/login', 'FacebookController@login')->name('FbLogin');
Route::get('/facebook/redirect', 'FacebookController@redirect')->name('FbRedirect');
Route::get('/facebook/callback', 'FacebookController@callback')->name('FbCallback');
