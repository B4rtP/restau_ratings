<?php

use Src\core\router\Router;
use Src\exceptions\RouteNotFoundException;

session_start();

define('ROOT_PATH', dirname(__DIR__). '/');
define('CORE_PATH', ROOT_PATH . 'src/core/');

require_once ROOT_PATH . 'vendor/autoload.php';
require_once CORE_PATH . 'router/routes.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

try {
    
    Router::getInstance()->resolve($_SERVER['REQUEST_METHOD'], $_GET['query'] ?? '');

} catch (RouteNotFoundException) {

    // StatusController

}


