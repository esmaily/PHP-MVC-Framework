<?php
namespace App\Http;

class Session
{
	private static $_sessionId;

	public static function init ()
	{
		if(!session_id()){
			session_start();
			self::$_sessionId = session_id();
		}
	}
	public static function is($key)
	{
			 return $key ?: FALSE;
	}
	public static function set ($key,$value)
	{
		if(!isset($_SESSION[$key])){
			return $_SESSION[$key]=$value;
		}
	}
	public static function get ($key)
	{
		if(isset($_SESSION[$key])){
			return $_SESSION[$key];
		}
		return FALSE;
	}

	public static function flush ($key)
	{
		$value = isset($_SESSION[$key]) ? self::get($key) : [] ;
		unset($_SESSION[$key]);
		return $value;
	}
	public static function clear ()
	{
			session_destroy();
	}

}