<?php

use Src\controllers\EntryController;
use Src\core\router\Router;
use Src\controllers\MainController;
use Src\controllers\RestaurantController;
use Src\controllers\ReviewController;

Router::getInstance()

->get('', [MainController::class => 'index'])
->post('search', [MainController::class => 'searchRestaurants'])

->get('restaurant', [RestaurantController::class => 'index'])

->get('sign_in', [EntryController::class => 'login'])
->get('sign_up', [EntryController::class => 'register'])
->post('sign_up', [EntryController::class => 'registerSubmit'])
->post('sign_in', [EntryController::class => 'loginSubmit'])
->get('sign_out', [EntryController::class => 'logout'])

->get('my_review', [ReviewController::class => 'index'])
->post('submit_new_review', [ReviewController::class => 'submitNewReview'])
->get('edit_my_review', [ReviewController::class => 'displayEditForm'])
->post('edit_my_review', [ReviewController::class => 'updateReview'])
->post('delete_review', [ReviewController::class => 'deleteReview']);