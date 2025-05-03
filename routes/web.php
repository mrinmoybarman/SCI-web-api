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

// Hospital routes bundle as resource 
Route::resource('hospitals', HospitalController::class)->middleware('auth');

// patient footfall 
Route::resource('footfall', FootfallController::class)->middleware('auth');


// doctor routes 
Route::resource('doctors', DoctorController::class)->middleware('auth');

