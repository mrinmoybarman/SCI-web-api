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

// this is to fetch all doctor from a center  
Route::post('/get-hospitals', 'api@getHospitals');

Route::get('/get-hospital/{id}', 'api@getSingleHospital');

// this is to fetch all doctor from a center  
Route::post('/get-doctor-for-center', 'api@getCentreDoctor');

Route::get('/get-doctor/{id}', 'api@getSingleDoctor');

// this is to fetch latest footfall count of a center  
Route::post('/get-counts-for-center', 'api@getCentreFootfall');

// this is to fetch all facility of a center  
Route::post('/get-facility-for-center', 'api@getFecility');

// this is to fetch all news & events of a center  
Route::post('/get-news-events-for-center', 'api@getCentreNewsEvents');

// this is to fetch all news & events of a center  
Route::post('/get-slides-for-center', 'api@getCentreSlides');


// this is to fetch all news update of a center  
Route::post('/get-updates-for-center', 'api@getCentreUpdate');


// this is to sent messsage
Route::post('/submit-message', 'EnquiryController@store');


