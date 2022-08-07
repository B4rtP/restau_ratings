<?php

namespace Src\exceptions;

use Exception;

class InvalidPropertyException extends Exception {

    protected $message = 'Property was not found';

}