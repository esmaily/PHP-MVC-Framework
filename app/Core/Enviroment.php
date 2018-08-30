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

class Enviroment{

	private static $_config;

	public static function get($path)
	{
		self::$_config = self::$_config ? self::$_config : json_decode(file_get_contents(ROOT . 'env'),true);
		if(isset(self::$_config[$path]))
			{
				
				return self::$_config[$path];
			}
			else{
				(new FoundException())->run("Environment Error","Enviroment Load Error Object({$path})");
			}
	}
}