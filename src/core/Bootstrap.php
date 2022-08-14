<?php

namespace Src\core;

use Dotenv\Dotenv;
use PDOException;
use Src\core\router\Router;

class Bootstrap {

    public function __construct(

        private DB $dbInstance,
        private Router $routerInstance

    ){}

    public function init() {

        $dotenv = Dotenv::createImmutable(ROOT_PATH);
        $dotenv->load();

        try {

            $this->dbInstance->connect($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);

        } catch (PDOException $e) {

            throw new PDOException($e->getMessage(), $e->getCode());
        
        }

        $this->routerInstance->resolve($_SERVER['REQUEST_METHOD'], $_GET['query'] ?? '');

    }

    public function __invoke() {
        
        $this->init();

    }

}