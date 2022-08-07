<?php

namespace Src\core;

use PDO;

abstract class Entity {

    protected function __construct(

        protected PDO $dbc,
        protected string $table

    ) {}

    public function findAll() {

        $sql = 'SELECT * FROM '. $this->table;

        $stmt = $this->dbc->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll();

    }

}