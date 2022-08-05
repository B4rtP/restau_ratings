<?php

namespace Src\entities;

use Src\core\Entity;

class User extends Entity {

    public function __construct($dbc) {
        
        parent::__construct($dbc, 'users');

    }

}