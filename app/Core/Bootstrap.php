<?php
/*
 * 18th National Skills Competition  trade of Web Design And Development
 * Competitor : Seyed Jaffar Esmaili
 * GitHub : esmaily
 * Email : jaffar9898@gmail.com
 *
 * */

namespace App\Core;


use App\Core\Exceptions\FoundException;

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