<?php

namespace Src\exceptions;

use Exception;

class InvalidDataTypeException extends Exception {

    public function __construct($dataType) {
        
        $this->message = 'Data type must be '. $dataType;

    }

}