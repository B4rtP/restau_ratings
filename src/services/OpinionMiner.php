<?php

namespace Src\services;

use PDO;
use Src\entities\Keyword;
use Src\enums\MatchMode;
use Src\enums\OpinionResult;

class OpinionMiner {

    public function __construct(

        private PDO $dbc

    ) {}

    public function fromInput(string ...$inputs) {
        
        $parsed = explode(' ', implode(' ', $inputs));

        $keywords = (new Keyword($this->dbc))
        ->select('keyword', 'type')
        ->findMatches(['keyword'], $parsed, MatchMode::STRICT);

        $score = 0;

        foreach ($keywords as $keyword) {

            if ( (int) $keyword->type === 1) {

                $score++;

            } else {

                $score--;

            }
        }

        if ($score > 0) {

            return OpinionResult::POSITIVE;

        }

        if ($score < 0) {

            return OpinionResult::NEGATIVE;

        }

        return $keywords ? OpinionResult::EQUALITY : OpinionResult::NO_MATCHES;
    }
}