<?php
/*
 * 18th National Skills Competition  trade of Web Design And Development
 * Competitor : Seyed Jaffar Esmaili
 * GitHub : esmaily
 * Email : jaffar9898@gmail.com
 *
 * */

namespace App\Core;


class Language
{
	public static function get ($path)
	{
		$path = explode('.',$path);
		$langFile =  ENV['LANG_PATH'] . ENV['LANG_DEF'] . DS .'validation.json';
		if(!is_readable($langFile)){
			$langFile=ENV['LANG_PATH']. 'en'.DS .'validation.json';
		}
		$lang =json_decode(file_get_contents($langFile),TRUE);
		if(count($path) == 1){
			return $lang[$path[0]];
		}
		return $lang[$path[0]][$path[1]];
	}
}