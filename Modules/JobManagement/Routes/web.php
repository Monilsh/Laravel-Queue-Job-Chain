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

Route::prefix('jobmanagement')->group(function() {
    Route::get('/', 'JobManagementController@index');
    Route::get('/test', 'JobManagementController@test');
    Route::get('/chainJobs', 'JobManagementController@chainJobs');
    Route::get('/getName', 'JobManagementController@printHello');

});
