<?php

namespace Src\services;

use Src\exceptions\InvalidDataTypeException;
use Src\exceptions\InvalidPropertyException;
use Src\interfaces\HelperInterface;

class Formatter {

    private function __construct(

        private object|array $subject

    ) {}

    public static function convert(object|array $subject):static {

        return new static($subject);

    }

    public function use(HelperInterface ...$tools):self {

        if (is_array($this->subject)) {

            foreach ($this->subject as $item) {

                if (! is_object($item)) {
                    throw new InvalidDataTypeException('object');
                }

                $this->convertObjectProperty($item, $tools);
            }
            
            return $this;
        }

        $this->convertObjectProperty($this->subject, $tools);

        return $this;
    }

    private function convertObjectProperty(object $obj, array $tools) {

        foreach ($tools as $tool) {

            $property = $tool->key;

            property_exists($obj, $property) ?: throw new InvalidPropertyException();

            if (! is_null($obj->$property)) {

                $obj->$property = $tool->run($obj->$property);

            }
        }
    }
}