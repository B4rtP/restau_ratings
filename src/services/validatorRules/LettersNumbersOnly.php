<?php

namespace Src\services\validatorRules;

use Src\interfaces\ValidatorRuleInterface;

class LettersNumbersOnly implements ValidatorRuleInterface {

    public function validate($subject): bool|string {
        
        if (preg_match('/[^A-Za-z0-9]+/', $subject)) {

            return 'field can contain only letters a-z, A-Z and numbers';

        }

        return true;

    }

}