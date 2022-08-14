<?php

namespace Src\services\helpers;

use DateTime;
use Src\exceptions\InvalidDataTypeException;
use Src\interfaces\HelperInterface;

class PrettyDateTime implements HelperInterface {

    const CUSTOM_FORMAT = 'd.m.Y H:i';

    public function __construct(
        
        public int|string $key
        
    ) {}

    public function run(mixed $field):string {

        if (! is_string($field)) {

            throw new InvalidDataTypeException('string');
        }
        
        return (new DateTime($field))->format(self::CUSTOM_FORMAT);

    }


       


        
    

}