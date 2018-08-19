<?php


use App\Http\Route;
use App\Http\Session;

function d ($data = '')
{
	echo "<pre style='background: #333;color: #eee;padding: 10px;direction: ltr;text-align: left;'>";
	print_r($data);
	echo "</pre>";

}

function dd ($data = '')
{
	echo "<pre style='background: #333;color: #eee;padding: 10px;direction: ltr;text-align: left;'>";
	print_r($data);
	echo "</pre>";
	die();
}

function dump ($data = '')
{
	echo "<pre style='background: #333;color: #eee;padding: 10px;direction: ltr;text-align: left;'>";
	var_dump($data);
	echo "</pre>";

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

# Read Json File Width Key
function getData ($key = NULL)
{
	$data = json_decode(file_get_contents(ENV['DATABASE']), TRUE);
	switch ($key) {
		case $key == NULL:
			return $data;
			break;
		case is_string($key):
			if (array_key_exists($key, $data))
				return $data[$key];
			break;
		case is_array($key) :
			if (count($key) == 2) {
				return $data[$key[0]][$key[1]];
			} elseif (count($key) == 3) {
				return $data[$key[0]][$key[1]][$key[2]];
			} elseif (count($key) == 4) {
				return $data[$key[0]][$key[1]][$key[2]][$key[3]];
			}
			break;
		default:
			return TRUE;
	}
}

# Insert Json File Width Key
function setData ($key, $val)
{
	$data = json_decode(file_get_contents(ENV['DATABASE']), TRUE);
	switch ($key) {
		case is_string($key):
			if (array_key_exists($key, $data))
				$data[$key] = $val;
			break;
		case is_array($key) :
			if (count($key) == 2) {
				$data[$key[0]][$key[1]] = $val;
			} elseif (count($key) == 3) {
				$data[$key[0]][$key[1]][$key[2]] = $val;
			} elseif (count($key) == 4) {
				$data[$key[0]][$key[1]][$key[2]][$key[3]] = $val;
			}
			break;
		default:
			return TRUE;
	}
	$rawData = json_encode($data, TRUE);
	file_put_contents(ENV['DATABASE'], ' ');
	file_put_contents(ROOT . 'resources/database.json', $rawData);

	return TRUE;
}

# Insert Json File Width Key
function storeData ($key, $val)
{
	$data                   = json_decode(file_get_contents(ENV['DATABASE']), TRUE);
	$data[$key[0]][$key[1]] = $val;
	$jsonData               = json_encode($data, JSON_PRETTY_PRINT);
	file_put_contents(ENV['DATABASE'], ' ');
	header('Content-type: text/html; charset=UTF-8');
	file_put_contents(ROOT . 'resources/database.json', $jsonData);

	return $data;
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

function back ($params = NULL)
{
	Session::set('bag', $params);
//	dd($params);
	header("location: " . ENV['BACK']);
	exit();
}