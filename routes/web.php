<?php
// use App\Http\Controllers\NewsAndEventController;

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

// facilities routes 
Route::resource('facilities', FacilityController::class)->middleware('auth');

// news_and_events routes // multiple images
Route::resource('news_and_events', NewsAndEventController::class)->middleware('auth');
Route::resource('news-event-photos', NewsEventPhotoController::class)->middleware('auth');


// updates routes 
Route::resource('updates', UpdatesController::class)->middleware('auth');

// slides routes 
Route::resource('slides', SlidesController::class)->middleware('auth');

// slides routes 
Route::resource('enquiries', EnquiryController::class)->middleware('auth');

// Partners routes 
Route::resource('partners', PartnerController::class)->middleware('auth');

// Partners routes 
Route::resource('about_sections', AboutSectionController::class)->middleware('auth');
