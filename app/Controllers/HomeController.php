<?php


namespace App\Controllers;


use App\Http\{
	Controller, Model, Request
};


class HomeController extends Controller
{
	public function indexAction ()
	{
		$advertises= Model::table('advertise')->all();
		$this->render('home',compact('advertises'));
	}
}