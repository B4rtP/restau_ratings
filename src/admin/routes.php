<?php

use Src\admin\controllers\DashboardController;
use Src\admin\controllers\EntryController;
use Src\admin\controllers\KeywordController;
use Src\admin\controllers\RestaurantController;
use Src\core\router\Router;

$router = Router::getInstance();

if (! isset($_SESSION['admin'])) {
    
    $router
    ->get('', [EntryController::class => 'index'])
    ->post('', [EntryController::class => 'loginSubmit']);

    return;
}

$router
->post('logout', [EntryController::class => 'logout'])

->get('', [DashboardController::class => 'index'])

->get('restaurants', [RestaurantController::class => 'index'])
->post('restaurants', [RestaurantController::class => 'addRestaurant'])
->post('delete_restaurant', [RestaurantController::class => 'deleteRestaurant'])

->get('keywords', [KeywordController::class => 'index'])
->post('keywords', [KeywordController::class => 'addKeyword'])
->post('delete_keyword', [KeywordController::class => 'deleteKeyword']);