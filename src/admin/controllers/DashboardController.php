<?php

namespace Src\admin\controllers;

use Src\core\Controller;
use Src\core\View;

class DashboardController extends Controller {

    public function indexAction() {

        View::display('dashboard')->setLayout('menu');

    }

}