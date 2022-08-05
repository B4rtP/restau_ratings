<?php

namespace Src\exceptions;

use Exception;

class ViewNotFoundException extends Exception {

    public function __construct($viewType) {

        $this->message = $viewType. ' was not found';

    }

}