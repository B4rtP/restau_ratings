<?php

namespace Src\exceptions;

use Exception;

class RouteNotFoundException extends Exception {

    protected $message = 'Route was not found';

}