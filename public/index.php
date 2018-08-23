<?php

use App\Http\Bootstrap;
include '../vendor/autoload.php';
//set_error_handler('handler');
$bootstrap = new Bootstrap();
$bootstrap->run();