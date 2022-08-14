<?php

namespace Src\services\validatorRules;

use Src\interfaces\ValidatorRuleInterface;

class ValidateEmail implements ValidatorRuleInterface {

    public function validate($subject): bool|string {
        
        if (! filter_var($subject, FILTER_VALIDATE_EMAIL)) {

            return 'email must be valid email address';

        }

        return true;

    }

}