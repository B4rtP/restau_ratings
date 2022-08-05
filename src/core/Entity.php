<?php

namespace Src\core;

use PDO;

abstract class Entity {

    protected function __construct(

        protected PDO $dbc,
        protected string $tableName
    ) {}

}