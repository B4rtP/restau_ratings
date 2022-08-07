<?php

namespace Src\services;

use PDO;
use Src\entities\Keyword;

class OpinionMiner {

    const NO_MATCHES =  'no matches';
    const NEGATIVE = 'negative';
    const MIDDLE = 'middle';
    const POSITIVE = 'positive';

    public function __construct(

        private PDO $dbc
    ) {}

    public function run(string ...$inputs) {

        $merged = implode(' ', $inputs);

        $keywordObjs = (new Keyword($this->dbc))->findAll();

        $score = 0;

        foreach ($keywordObjs as $kwObj) {

            if (strpos($merged, (string) $kwObj->keyword) !== false) {

                (int) $kwObj->type === 1 ? $score++ : $score-- ;

                $matchedAtLeastOnce = true;

            }

        }

        if ($score > 0) {

            return self::POSITIVE;

        }

        if ($score < 0) {

            return self::NEGATIVE;

        }

        return $matchedAtLeastOnce ?? false ? self::MIDDLE : self::NO_MATCHES;
    }

}