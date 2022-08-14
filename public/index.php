<?php

use Src\controllers\StatusController;
use Src\core\Bootstrap;
use Src\core\DB;
use Src\core\router\Router;
use Src\exceptions\RouteNotFoundException;

session_start();

define('ROOT_PATH', dirname(__DIR__). '/');
define('VIEW_PATH', ROOT_PATH . 'src/views/');

require_once ROOT_PATH . 'vendor/autoload.php';
require_once ROOT_PATH . 'src/core/router/routes.php';

try {

    $bootstrap = new Bootstrap(DB::getInstance(), Router::getInstance());
    $bootstrap();

} catch (RouteNotFoundException) {

    (new StatusController())->runAction('pageNotFound');

}
