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

Route::get('/home', 'HomeController@index')->middleware('auth.lock')->name('home');

Route::get('login/locked', 'Auth\LoginController@locked')->middleware('auth')->name('login.locked');
Route::post('login/locked', 'Auth\LoginController@unlock')->name('login.unlock');
