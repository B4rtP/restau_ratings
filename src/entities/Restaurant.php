<?php

use Src\core\Entity;

class Restaurant extends Entity {

    public function __construct($dbc) {
        
        parent::__construct($dbc, 'restaurants');

    }

}