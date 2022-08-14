<?php

namespace Src\services\validatorRules;

use Src\interfaces\ValidatorRuleInterface;

class UrlFriendly implements ValidatorRuleInterface {

    public function validate($subject): bool|string {
        
        if (preg_match("/[!*'();:@&=+$,\/?# [\]]/", $subject)) {

            return "field must not contain any of following characters: /!*'();:@&=+$,\/?# []";

        }

        return true;

    }

}