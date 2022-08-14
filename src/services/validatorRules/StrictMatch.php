<?php

namespace Src\services\validatorRules;

use Src\interfaces\ValidatorRuleInterface;

class StrictMatch implements ValidatorRuleInterface {

    public function __construct(

        private string|int $compareWith

    ){}

    public function validate($subject): bool|string {
        
        if ($subject !== $this->compareWith) {

            return 'fields are not matching';

        }

        return true;

    }

}