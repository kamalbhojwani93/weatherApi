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

Route::get('/', 'App\Http\Controllers\HomeController@index')->name('weather-listing');

// get weather data from db
Route::get('/weather/ajax/list', 'App\Http\Controllers\HomeController@ajaxlist')->name('weather.ajax.list');

// Get weather data
Route::get('/get-weather-data', 'App\Http\Controllers\WeatherController@index')->name('get-weather-data');