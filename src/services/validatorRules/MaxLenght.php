<?php

namespace Src\services\validatorRules;

use Src\interfaces\ValidatorRuleInterface;

class MaxLenght implements ValidatorRuleInterface {

    public function __construct(
        
        private string|int $maxLenght

    ) {}

    public function validate($subject): bool|string {
        
        if (strlen($subject) > (int) $this->maxLenght) {

            return 'lenght must be below ' . $this->maxLenght . ' characters';

        }

        return true;

    }

}