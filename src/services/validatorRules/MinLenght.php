<?php

namespace Src\services\validatorRules;

use Src\interfaces\ValidatorRuleInterface;

class MinLenght implements ValidatorRuleInterface {

    public function __construct(

        private string|int $minLenght

    ) {}

    public function validate($subject): bool|string {
        
        if (strlen($subject) < (int) $this->minLenght) {

            return 'lenght must be over ' . $this->minLenght . ' characters';

        }

        return true;

    }

}