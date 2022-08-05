<?php

namespace Src\entities;

use Src\core\Entity;

class Keyword extends Entity {

    public function __construct($dbc) {
        
        parent::__construct($dbc, 'keywords');

    }

}