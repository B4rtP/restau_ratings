<?php

use Src\core\router\Router;
use Src\controllers\MainController;

Router::getInstance()

->get('', [MainController::class => 'index']);