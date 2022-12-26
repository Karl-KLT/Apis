<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('server')->group(function(){
    // APP SETTINGS
    Route::prefix('App')->group(function(){
        // get app info
        Route::get('GET_APP','ApiController@APP');
        // update app info
        Route::post('UPDATE_APP','ApiController@UPDATE_APP');
    });

    // authentication
    Route::prefix('Auth')->group(function(){
        // Profile
        Route::post('Profile','ApiController@Profile');
        // Login
        Route::post('Login','ApiController@Login');
        // Register
        Route::post('Register','ApiController@Register');
    });
    // Sliders Settings
    Route::prefix('Slider')->group(function(){
        // Set new data for Slider
        Route::post('SET_Slider','ApiController@SET_Slider');
    });

    Route::prefix('Categories')->group(function(){
        // Set new data for Categories
        Route::post('SET_Categories','ApiController@SET_Categories');
        // Get all data for Categories
        Route::post('GET_Categories','ApiController@GET_Categories');

        Route::post('SET_Product','ApiController@SET_Product');
        Route::post('GET_Product','ApiController@GET_Product');

    });

    Route::get('GET_All','ApiController@GET_All');



    Route::get('SET_Future','ApiController@SET_Future');

    Route::get('GET_Future','ApiController@GET_Future');
});
