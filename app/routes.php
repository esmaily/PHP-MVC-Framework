<?php
	# Project Routes


use App\Advertise;
use App\Http\Model;
use App\Http\Route;
use App\Http\Session;
use App\User;

Route::get('/','HomeController@index');
Route::get('advertise/add','AdvertiseController@create');
Route::get('advertise/show/{id}','AdvertiseController@show');
Route::post('advertise/store','AdvertiseController@store');
Route::get('advertise/show/{code}','AdvertiseController@show');
