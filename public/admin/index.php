<?php

use Src\core\Bootstrap;
use Src\core\DB;
use Src\core\router\Router;
use Src\exceptions\RouteNotFoundException;

session_start();

define('ROOT_PATH', dirname(dirname(__DIR__)). '/');
define('VIEW_PATH', ROOT_PATH . 'src/admin/views/');
define('UPLOAD_PATH', ROOT_PATH . 'public/uploads/');
define('RESTAURANTS_IMAGES', ROOT_PATH . 'public/assets/images/restaurants/');

require_once ROOT_PATH . 'vendor/autoload.php';
require_once ROOT_PATH . 'src/admin/routes.php';
require_once ROOT_PATH . 'src/admin/config.php';

try {

    $bootstrap = new Bootstrap(DB::getInstance(), Router::getInstance());
    $bootstrap();

} catch (RouteNotFoundException) {

    header('Location:/admin');
    exit;

}


