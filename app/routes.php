<?php
# Project Routes

use App\Http\Route;

Route::get('/','HomeController@index');
Route::get('advertise/add','AdvertiseController@create');
Route::get('advertise/show/{id}','AdvertiseController@show');
Route::post('advertise/store','AdvertiseController@store');
Route::get('advertise/show/{code}','AdvertiseController@show');
