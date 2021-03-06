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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api', 'middleware' => 'throttle:60,1'], function() {
    Route::get('/list-pharmacies', 'PharmacyController@getAllPharms');
    Route::post('/add-pharmacy', 'PharmacyController@addPharmacy');
    Route::post('/update-pharmacy', 'PharmacyController@updatePharmacy');
    Route::get('delete-pharm/{id}', 'PharmacyController@deletePharmacy');

});
