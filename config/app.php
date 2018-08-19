<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)) . DS);

# Url Defines
define('URL', [
	'BASE'   => $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . str_replace('public/index.php', '', $_SERVER['SCRIPT_NAME']),
	'PUBLIC' => ROOT . 'public' . DS,

]);

# Path Defines
define('PATH', [
	'PUBLIC'     => URL['BASE'] . 'public/',
]);
# View Defines
define('VIEW', [
	'PATH'      => ROOT . 'resources/views' . DS,
	'EXTENSION' => '.twig',
]);

# Env Defines
define('ENV', [
	'DATABASE'     => ROOT . 'resources' . DS . 'database.json',
	'LANG_PATH'    => ROOT . 'resources' . DS . 'lang' . DS,
	'LANG_DEF' => 'fa',
	'STORAGE'      => PATH['PUBLIC'] . 'storage' . DS,
	'BACK'=>$_SERVER['HTTP_REFERER']
]);
