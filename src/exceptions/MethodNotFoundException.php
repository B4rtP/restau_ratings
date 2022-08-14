<?php

namespace Src\exceptions;

use Exception;

class MethodNotFoundException extends Exception {

    protected $message = 'Method was not found';

}