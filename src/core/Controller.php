<?php

namespace Src\core;

use PDO;
use Src\exceptions\MethodNotFoundException;

abstract class Controller {

    protected PDO $dbc;
    protected array $urlParams;

    public function init(array $urlParams) {

        $this->dbc = DB::getInstance()->getConnection();
        
        $this->urlParams = $urlParams;

        return $this;

    }

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