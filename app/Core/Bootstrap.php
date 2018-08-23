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
		$url = $_GET['url'] ?? '/';
		$url        = strtolower($url);
		Route::route($url);
	}
}