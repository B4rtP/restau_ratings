<?php

namespace Src\core;

use Src\exceptions\MethodNotFoundException;

abstract class Controller {

    public function runAction($action) {

        $beforeAction = 'beforeAction';

        if (method_exists($this, $beforeAction)) {

            $continue = $this->$beforeAction();

            $continue === true ?: exit;
        }

        $action .= 'Action';

        if (! method_exists($this, $action)) {

            throw new MethodNotFoundException();

        }
        
        $this->$action();

    }

}