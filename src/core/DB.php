<?php

namespace Src\core;

use PDO;

final class DB {

    private static ?self $instance = null;

    private PDO $connection;

    private function __construct()
    {}

    public static function getInstance():self {

        if (is_null(self::$instance)) {

            self::$instance = new self();

        }

        return self::$instance;

    }

    public function connect($dbHost, $dbName, $username, $password):void {

        $this->connection = new PDO(
            'mysql:host=' . $dbHost .
            ';dbname=' . $dbName . ';',
            $username,
            $password);

    }

    public function getConnection():PDO {

        return $this->connection;

    }

}