<?php

namespace Src\enums;

enum OpinionResult:string {

    case NO_MATCHES = 'no_matches';
    case NEGATIVE = 'negative';
    case EQUALITY = 'equality';
    case POSITIVE = 'positive';

    public function getArithmeticValue():int|float|null {

        return match($this) {

            self::NO_MATCHES => null,
            self::NEGATIVE => 0,
            self::EQUALITY => 0.5,
            self::POSITIVE => 1

        };

    }

}