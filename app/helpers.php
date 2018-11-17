<?php
/*
 * 18th National Skills Competition  trade of Web Design And Development
 * Competitor : Seyed Jaffar Esmaili
 * GitHub : esmaily
 * Email : jaffar9898@gmail.com
 *
 * */

use App\Core\Exceptions\FoundException;
use App\Core\Route;
use App\Core\Session;

function abort ($data = '')
{
	(new FoundException())->run('Aborted',$data);
}

function d ($data = '')
{
	echo "<pre style='background: #333;color: #eee;padding: 10px;direction: ltr;text-align: left;'>";
	print_r($data);
	echo "</pre>";

}

function dump ($data = '')
{
	echo "<pre style='background: #333;color: #eee;padding: 10px;direction: ltr;text-align: left;'>";
	var_dump($data);
	echo "</pre>";
	die();
}

function clearArray (&$array, $key = '')
{
	$ret = [];
	foreach ($array as $index => $value) {
		if ($value !== $key)
			$ret[$index] = $value;
	}
	$array = $ret;
}

# sticky values
function wrapValue ($var, $wrapStart = '`', $wrapEnd = NULL)
{
	if ($wrapEnd === NULL) {
		$wrapEnd = $wrapStart;
	}
	if (is_array($var)) {
		foreach ($var as $key => $value) {
			if ($wrapEnd !== 'var') {
				$var[$key] = $wrapStart . $var[$key] . $wrapEnd;
			} else {
				$var[$key] = $wrapStart . $var[$key] . $wrapStart . '=:' . $var[$key];
			}
		}

		return $var;
	} else {
		if ($wrapEnd !== 'var') {
			return $wrapStart . $var . $wrapEnd;
		} else {
			return $wrapStart . $var . $wrapStart . '= :' . $var;
		}
	}
}

function strRepeatVal ($var, $arr, $join = '')
{
	$array = array_fill(0, count($arr), $var);

	return implode($join, $array);
}
# Generate Random Key
function shuffleKey ()
{
	$str = [1, 2, 3, 4, 3, 5, 6, 7, 8, 9, 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
	$key = '';
	for ($i = 1; $i < 15; $i++) {
		$key .= $str[rand(0, 35)];
	}

	return $key;
}
# Redirect to
function redirect ($route, $params = NULL)
{
	$r     = Route::getRouteAction($route, ['method' => 'GET']);
	$route = $route === '/' ? '' : $route;
	if ($r) {
		Session::set('bag', $params);
		header("location: " . BASE . '/' . $route);
		exit();
	} else {
		throw new \Exception("redirect \error {{ $route }} URL !", 1);
	}
}

# return back page
function back ($params = NULL)
{
	Session::set('bag', $params);
//	dd($params);
	header("location: " . ENV['BACK']);
	exit();
}

function handler()
{
	return (new FoundException)->handler();
}