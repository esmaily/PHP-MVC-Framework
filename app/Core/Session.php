<?php
/*
 * 18th National Skills Competition  trade of Web Design And Development
 * Competitor : Seyed Jaffar Esmaili
 * GitHub : esmaily
 * Email : jaffar9898@gmail.com
 *
 * */

namespace App\Core;

class Session
{
	private static $_sessionId;

	public static function init ()
	{
		if (!session_id()) {
			session_start();
			self::$_sessionId = session_id();
			//			unset($_SESSION);
		}
	}

	public static function is ($key)
	{
		return $_SESSION[$key] ?: FALSE;
	}

	public static function set ($key, $value)
	{
		return $_SESSION[$key] ?? $_SESSION[$key] = $value;
	}

	public static function get ($key)
	{
		return $_SESSION[$key] ?? FALSE;
	}

	public static function flush ($key)
	{
		$value = isset($_SESSION[$key]) ? self::get($key) : [];
		unset($_SESSION[$key]);

		return $value;
	}

	public static function clear ()
	{
		session_destroy();
	}

}