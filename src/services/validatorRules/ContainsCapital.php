<?php

namespace Src\services\validatorRules;

use Src\interfaces\ValidatorRuleInterface;

class ContainsCapital implements ValidatorRuleInterface {

    public function validate($subject): bool|string {
        
        if (! preg_match('/[A-Z]/', $subject)) {

            return 'at least one capital letter is required';

        }

        return true;

    }

}