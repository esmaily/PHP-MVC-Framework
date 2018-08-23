<?php
	# Project Routes


use App\Http\Model;
use App\Http\Route;
use App\Http\Session;

Route::get('/','HomeController@index');
Route::get('advertise/add','AdvertiseController@create');
Route::get('advertise/show/{id}','AdvertiseController@show');
Route::post('advertise/store','AdvertiseController@store');
Route::get('advertise/show/{code}','AdvertiseController@show');

# Test Route
Route::get('update',function (){
	$ad= Model::table('advertise')->first(1);
	$ad->title='new title';
	$ad->code='sdfd';
//	$ad->update();
	d($ad);

});