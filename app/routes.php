<?php
/*
 * 18th National Skills Competition  trade of Web Design And Development
 * Competitor : Seyed Jaffar Esmaili
 * GitHub : esmaily
 * Phone : 09145985243
 *
 * */
# Project Routes

use App\Core\Route;




Route::get('/','HomeController@index');
Route::get('advertise/add','AdvertiseController@create');
Route::get('advertise/show/{id}','AdvertiseController@show');
Route::post('advertise/store','AdvertiseController@store');
Route::get('advertise/show/{code}','AdvertiseController@show');
