<?php


namespace App\Http;


use App\Http\Exceptions\FoundException;

class Bootstrap
{


	public function __construct ()
	{
		Session::init();
		FoundException::init();
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