<?php


namespace App\Controllers;


use App\Core\{
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