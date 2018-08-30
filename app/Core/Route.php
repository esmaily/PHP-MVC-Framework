<?php
/*
 * 18th National Skills Competition  trade of Web Design And Development
 * Competitor : Seyed Jaffar Esmaili
 * GitHub : esmaily
 * Phone : 09145985243
 *
 * */

namespace App\Core;

use App\Core\Exceptions\FoundException;
use App\Core\Exceptions\NotFoundException;

class Route
{

	private static $_routes = [],
		$_defaultRoute = [
		'method' => "ALL",
		'auth'   => FALSE,
	];

	public static function route ($url)
	{
		$checkedRoute = self::checkRoute($url);

		if (is_callable($checkedRoute['action'])) {
			call_user_func_array($checkedRoute['action'], $checkedRoute['params']);
		} elseif ($checkedRoute !== FALSE) {
			$urlParts = explode('@', $checkedRoute['action']);

			$controllerName = 'App\\Controllers\\' . ucfirst($urlParts[0]);
			$actionName     = (isset($urlParts[1]) ? $urlParts[1] : 'index') . 'Action';
			$params         = $checkedRoute['params'];
			if (count($params) == 0) {
				$params[0] = Request::createFromGlobals();
			}
			$ctrl = new $controllerName();

			if (method_exists($ctrl, $actionName)):

				call_user_func_array([$ctrl, $actionName], $params);
			else:
				(new FoundException())->run('404 : Action Not  Error','404 ! This Action Not Found ):');
			endif;

		} else {
			(new FoundException())->run('404 : Route Not Found Error','404 ! This Route Not Found ):');
		}

	}

	public static function register ($route, $routeAction, $config = [])
	{
		$config = self::getConfig($config);
		//		preg_match_all('/^([^{]+)\//', $route, $matches);
		preg_match_all('/^[^\{]+/', $route, $matches);
		$routeParams = [];
		$routeName   = isset($matches[0][0]) ? $matches[0][0] : $route;
		$routeName   = rtrim($routeName, '/');
		if ($routeName !== $route) {
			preg_match_all('/\/{([^}]+)}/U', $route, $matches);
			$routeParams = $matches[1];
		}
		$config['name']   = $routeName;
		$config['action'] = $routeAction;
		$config['params'] = $routeParams;
		$config['method'] = strtoupper($config['method']);
		self::$_routes[]  = $config;

	}

	public function getRouteAction ($url, $params = [])
	{
		$url = strtolower($url);
		foreach (self::$_routes as $conf) {
			$name    = strtolower($conf['name']);
			$len     = strlen($name);
			$urlName = substr($url, 0, $len);


			if (isset($url[$len]) && $url[$len] !== '/')
				continue;
			$urlParams = trim(substr($url, $len), '/');
			$urlParams = (($urlParams === '' || $urlParams === '/') ? [] : explode('/', $urlParams));
			if ($conf['name'] === $urlName && count($conf['params']) === count($urlParams)) {
				if (count($params) === 0) {
					return $conf['action'];
				}
				foreach ($params as $key => $value) {
					if ($conf[$key] === $value) {
						return $conf['action'];
					}
				}
			}
		}

		return NULL;
	}

	private static function checkRoute ($url)
	{
		foreach (self::$_routes as $conf) {

			$name         = strtolower($conf['name']);
			$filterParams = self::removeArbitaryParam($conf['params']);
			$urlName      = strtolower(rtrim(substr($url, 0, strlen($name . '/')), '/'));

			if ($name === ($urlName !== ' ' ? $urlName : '/')) {
				//				if($conf['auth'] &&  !\App\User::islogedIn()){
				//					continue;
				//				}
				if ($conf['method'] === 'ALL' || $_SERVER['REQUEST_METHOD'] === $conf['method']) {
					$urlParts = explode('/', trim(substr($url, strlen($name)), '/'));
					clearArray($urlParts);
					if ($name == '/' || count($conf['params']) >= count($urlParts)) {
						foreach ($urlParts as $index => $value) {
							if ($urlParts[$index])
								$filterParams[$index] = $urlParts[$index];
						}
						$conf['params'] = $filterParams;

						return $conf;
					}
				}
			}
		}

		return FALSE;
	}

	private static function removeArbitaryParam ($params)
	{
		$params2 = [];
		foreach ($params as $key => $value) {
			if ($value[0] === '?') {
				return $params2;
			}
			$params2 = $value;
		}

		return [];
	}

	private static function getConfig ($config)
	{
		$ret = self::$_defaultRoute;
		foreach ($config as $configName => $configValue) {
			$ret[$configName] = $configValue;

		}

		return $ret;
	}

	public static function __callStatic ($func, $args)
	{
		$args[2]           = isset($args[2]) ? $args[2] : [];
		$args[2]['method'] = $func;
		call_user_func_array([get_class(), 'register'], $args);
	}
}


 