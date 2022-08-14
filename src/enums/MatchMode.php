<?php

namespace Src\enums;

enum MatchMode:int {

    case STRICT = 1;
    case START = 2;
    case END = 3;
    case ANY = 4;

    public function appendWildcard(string $word):string {

        return match($this) {

            self::START => $word . '%',
            self::END => '%' . $word,
            self::ANY => '%' . $word . '%',
            default => $word

        };

    }

}