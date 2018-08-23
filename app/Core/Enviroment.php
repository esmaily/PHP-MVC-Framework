<?php
namespace App\Http;

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
				throw new \Exception("Enviroment Error Load Object({$path})", 1);
			}
	}
}