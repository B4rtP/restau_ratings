<?php

namespace Src\controllers;

use Src\core\Controller;
use Src\core\View;

class StatusController extends Controller {

    public function PageNotFoundAction() {

        http_response_code(404);
        
        return View::display('default')->setLayout('status-pages/404');

    }

}