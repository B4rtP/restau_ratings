<?php

namespace Src\services\validatorRules;

use Src\interfaces\ValidatorRuleInterface;

class ContainsDigit implements ValidatorRuleInterface {

    public function validate($subject): bool|string {
        
        if (! preg_match('/[0-9]/', $subject)) {

            return 'at least one digit is required';

        }

        return true;

    }

}