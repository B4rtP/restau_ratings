<?php

use Src\core\Entity;

class Review extends Entity {

    public function __construct($dbc) {
        
        parent::__construct($dbc, 'reviews');

    }

}