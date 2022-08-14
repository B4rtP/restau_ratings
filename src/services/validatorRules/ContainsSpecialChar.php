<?php

namespace Src\services\validatorRules;

use Src\interfaces\ValidatorRuleInterface;

class ContainsSpecialChar implements ValidatorRuleInterface {

    public function validate($subject): bool|string {
        
        if (! preg_match_all('/[^a-zA-Z0-9]/', $subject)) {

            return 'field must contain at least one special character';

        }

        return true;

    }

}