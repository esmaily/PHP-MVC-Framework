<?php

namespace App\Http;

class Cookie
{
	public static function set ($key,$value,$lifeTime=0)
	{
		$lifeTime += time();
		setcookie($key,$value,$lifeTime);
	}
	public static function get ($key)
	{
		if(isset($_COOKIE[$key])){
			return $_COOKIE[$key];
		}
		return FALSE;
	}

	public static function flush ($key)
	{
		$value = isset($_COOKIE[$key]) ? self::get($key) : [] ;
		setcookie($key,FALSE,-1);
		return $value;
	}
	public static function clear ()
	{

		foreach ($_COOKIE as $key=>$value)
		{
			setcookie($key,FALSE,-1);
		}
		return TRUE;
	}
}