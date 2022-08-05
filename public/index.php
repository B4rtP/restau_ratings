<?php

use Src\core\DB;
use Src\core\router\Router;
use Src\exceptions\RouteNotFoundException;

session_start();

define('ROOT_PATH', dirname(__DIR__). '/');
define('CORE_PATH', ROOT_PATH . 'src/core/');
define('VIEW_PATH', ROOT_PATH . 'src/views/');

require_once ROOT_PATH . 'vendor/autoload.php';
require_once CORE_PATH . 'router/routes.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

try {

    DB::getInstance()->connect($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);

} catch (PDOException $e) {

    throw new PDOException($e->getMessage(), $e->getCode());
}


try {
    
    Router::getInstance()->resolve($_SERVER['REQUEST_METHOD'], $_GET['query'] ?? '');

} catch (RouteNotFoundException) {

    // StatusController

}


