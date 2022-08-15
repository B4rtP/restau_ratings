<?php

namespace Src\services\helpers;

use Src\exceptions\InvalidDataTypeException;
use Src\interfaces\HelperInterface;

class ToPercent implements HelperInterface {

    public function __construct(

        public string|int $key

    ) {}

    public function run(mixed $field):float {

        if (! is_numeric($field)) {

            throw new InvalidDataTypeException('numeric');
        }

        return (float) floor($field * 100);

    }




}
