<?php

namespace Src\services;

use Src\exceptions\InvalidPropertyException;
use Src\interfaces\HelperInterface;

class Formatter {

    private function __construct(

        private object|array $subject

    ) {}

    public static function convert(object|array $subject):static {

        return new static($subject);

    }

    public function use(HelperInterface ...$tools):void {

        if (is_array($this->subject)) {

            foreach ($this->subject as $item) {

                foreach ($tools as $tool) {

                    if (is_object($item)) {

                        $property = $tool->key;

                        property_exists($item, $property) ?: throw new InvalidPropertyException();

                        if (! is_null($item->$property)) {

                            $item->$property = $tool->run($item->$property);

                        }
                    }
                    // If not an array...
                }
            }
            
            return;
        }

        foreach ($tools as $tool) {
            
            $property = $tool->key;

            property_exists($this->subject, $property) ?: throw new InvalidPropertyException();

            if (! is_null($this->subject->$property)) {

                $this->subject->$property = $tool->run($this->subject->$property);

            }
        }
    }
}