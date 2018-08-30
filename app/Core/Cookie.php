<?php
/*
 * 18th National Skills Competition  trade of Web Design And Development
 * Competitor : Seyed Jaffar Esmaili
 * GitHub : esmaily
 * Email : jaffar9898@gmail.com
 *
 * */

namespace App\Core;

class Cookie
{

	private static $_cookie;
	public function __construct ($key,$value=NULL,$lifeTime=NULL)
	{
		self::$_cookie=$_COOKIE;
		if($value==NULL){
			return self::get($key);
		}elseif ($key && $value !=$value)
		{
			self::set($key,$value,$lifeTime);
		}
		return FALSE;
	}

	public static function set ($key,$value,$lifeTime=0)
	{
		$lifeTime += time();
		setcookie($key,$value,$lifeTime);
	}
	public static function get ($key)
	{
		return self::$_cookie[$key] ?? FALSE;
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