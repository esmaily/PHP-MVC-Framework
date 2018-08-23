<?php

/*
 * 18th National Skills Competition  trade of Web Design And Development
 * Competitor : Seyed Jaffar Esmaili
 * GitHub : esmaily
 * Phone : 09145985243
 *
 * */

namespace App\Core;


class Request
{
	private $_get,
		$_post,
		$_file,
		$_all,
		$_upload = [];
	private static $singleton;

	public function __construct ($get, $post, $file, $request)
	{
		$this->_get  = $get;
		$this->_post = $post;
		$this->_file = $file;
		$this->_all  = $request;
		unset($_GET);
		unset($_POST);
		unset($_FILES);
		unset($_REQUEST);
	}

	# Register Default Globals Once For Alawaye
	public static function createFromGlobals ()
	{
		if (!isset(self::$singleton)) {
			self::$singleton = new static($_GET, $_POST, $_FILES, $_REQUEST);
		}

		return self::$singleton;
	}

	public function all ($keys = NULL)
	{
		unset($this->_all['url']);
		foreach ($this->_file as $key=>$value)
		{
			$this->_all[$key]=$value['name'];
		}
		if (!$keys) {
			return $this->_all ??  'No Request Input';
		} elseif (is_string($keys)) {
			return $this->_all[$keys] ?? 'No Request Input';
		} elseif (is_array($keys)) {
			$arr  = $this->_all ?? [];
			$data = [];
			for ($i = 0; $i < count($keys); $i++) {
				if (in_array($keys[$i], array_keys($arr))) {
					$data[$keys[$i]] = $arr[$keys[$i]];
				}
			}

			return $data;
		} else {
			return ' ';
		}
	}

	public function post ($key, $default = NULL)
	{
		return $this->_post[$key] ??  $default;
	}

	public function get ($key, $default = NULL)
	{
		return $this->_get[$key] ??  $default;
	}

	public function file ($key)
	{

		if (isset($this->_file[$key]) && $this->_file[$key]['error'] == 0) {
			$this->_upload['name']           = $this->check($this->_file[$key]['name']);
			$this->_upload['temporary_path'] = $this->_file[$key]['tmp_name'];

			return $this->_upload['name'];
		}
	}

	//	public function store ($name = NULL)
	//	{
	//		if (!$name) {
	//			$name = ENV['STORAGE'] . $this->_upload['name'];
	//			$file = $this->move('path', $name);
	//			if ($file) {
	//				echo 'storage' . DIRSEP . $this->_upload['name'];
	//			}
	//		} elseif ($name) {
	//			$path     = ENV['STORAGE'];
	//			$tempName = explode('.', $this->_upload['name']);
	//			$tempPath = explode('/', $name);
	//			$ext      = '.' . end($tempName);
	//			if ($tempPath[0] == NULL) {
	//				array_shift($tempPath);
	//			}
	//			$basename = $this->check(end($tempPath) . $ext);
	//			for ($i = 0; $i < (count($tempPath) - 1); $i++) {
	//				if (!is_dir($path . $tempPath[$i])) {
	//					mkdir($path . $tempPath[$i]);
	//				}
	//				$path .= $tempPath[$i] . DS;
	//			}
	//			if (is_dir($path)) {
	//				//				$//				$file = move_uploaded_file($this->_upload['temporary_path'], $path . $basename);
	//				$file = $this->move('path', $basename);
	//				if ($file) {
	//					echo $name . $ext;
	//				}
	//			}
	//		}
	//	}

	public function is ($request)
	{
		return $this->_all[$request] ? TRUE : FALSE;
	}

	private function check ($name)
	{
		$name1 = str_replace(' ', '_', $name);
		$name2 = str_replace('-', '_', $name1);
		$name3 = str_replace('/', '_', $name2);
		$name4 = str_replace('__', '_', $name3);
		$name5 = str_replace('___', '_', $name4);

		return $name5;
	}

	public function store ($path,$name)
	{
		$path = ENV['STORAGE'] . $path . DS;
		if (is_dir($path)) {
			return move_uploaded_file($this->_upload['temporary_path'], $path . $name) ?: TRUE;
		}
		return FALSE;
	}
}