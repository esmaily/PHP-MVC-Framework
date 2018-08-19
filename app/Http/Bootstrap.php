<?php


namespace App\Http;


class Bootstrap
{


	public function __construct ()
	{
		Session::init();
	}

	public function run ()
	{
//		$request    = Request::createFromGlobals();
//		$getRequest = $request->get('url');
		$url = $_GET['url'] ?? '/';
//		$url        = $getRequest ?? '/';
		$url        = strtolower($url);
		Route::route($url);
	}
}