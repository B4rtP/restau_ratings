<?php

namespace Src\entities;

use PDO;
use Src\core\Entity;

class AnonymousEntity extends Entity {

    protected string $table;

    public function __construct(PDO $dbc, string $table) {

        parent::__construct($dbc, $table);

    }

    public static function fromView(PDO $dbc, string $table):static {

        return new static($dbc, $table);

    }

}