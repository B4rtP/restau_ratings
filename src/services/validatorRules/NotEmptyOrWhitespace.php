<?php

namespace Src\services\validatorRules;

use Src\interfaces\ValidatorRuleInterface;

class NotEmptyOrWhitespace implements ValidatorRuleInterface {

    public function validate($subject): bool|string {
        
        if (empty(trim($subject))) {

            return 'field can not be empty';

        }

        return true;

    }

}