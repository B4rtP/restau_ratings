<?php

namespace Src\services\validatorRules;

use Src\interfaces\ValidatorRuleInterface;

class NumbersOnly implements ValidatorRuleInterface {

    public function validate($subject): bool|string {
        
        if (preg_match('/[^0-9]+/', $subject)) {

            return 'field can only contain numbers';

        }

        return true;

    }

}