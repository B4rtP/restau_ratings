<?php

namespace Src\services\validatorRules;

use Src\interfaces\ValidatorRuleInterface;

class LettersOnly implements ValidatorRuleInterface {

    public function validate($subject): bool|string {
        
        if (preg_match('/[^A-Za-z]+/', $subject)) {

            return 'field can contain only letters a-z or A-Z';

        }

        return true;

    }

}