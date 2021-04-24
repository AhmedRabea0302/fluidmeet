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
Route::group(['namespace' => 'Site'], function() {
    // Home PAge Controller
    Route::get('/', 'HomeController@index')->name('home');

    // Pharmacy Routes
    Route::get('/add-pharmacy', 'PharmacyController@getAddPharmacy')->name('add-pharmacy');
    Route::post('/add-pharmacy', 'PharmacyController@postAddPharmacy');

    Route::get('/update-pharm/{id}', 'PharmacyController@getUpdatePharmacy')->name('update-pharm');
    Route::post('/update-pharm/{id}', 'PharmacyController@postUpdatePharmacy')->name('update-pharm');

    Route::get('delete-pharm', 'PharmacyController@deletePharmacy')->name('delete-pharm');
});
