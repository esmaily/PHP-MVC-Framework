<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)) . DS);
define('BASE',"{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['SERVER_NAME']}" . str_replace('public/index.php', '', $_SERVER['SCRIPT_NAME']));

# Url Defines
define('URL', [
	'PUBLIC'   =>BASE .'public/',
	]);

# Path Defines
define('PATH', [
	'PUBLIC' => ROOT . 'public' . DS,
]);
# View Defines
define('VIEW', [
	'PATH'      => ROOT . 'resources/views' . DS,
	'EXTENSION' => '.twig',
]);

# Env Defines
define('ENV', [
	'NOW'       => date('Y-m-d_H-i-s'),
	'DATABASE'  => ROOT . 'resources' . DS . 'database.json',
	'LANG_PATH' => ROOT . 'resources' . DS . 'lang' . DS,
	'LANG_DEF'  => 'fa',
	'STORAGE'   => PATH['PUBLIC'] . 'storage' . DS,
	'BACK'      => $_SERVER['HTTP_REFERER'] ?? '/',
]);