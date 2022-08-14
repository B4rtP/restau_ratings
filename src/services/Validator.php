<?php

namespace Src\services;

use Src\interfaces\ValidatorRuleInterface;

class Validator {

    private string|int $subject;
    private string $errorKey;
    private array $errors;

    public function check(string|int $subject, string $errorKey):self {

        $this->subject = $subject;
        $this->errorKey = $errorKey;
        $this->errors[$errorKey] = '';

        return $this;

    }

    public function setRules(ValidatorRuleInterface ...$rules):self {

        foreach ($rules as $rule) {

            $result = $rule->validate($this->subject);

            if ($result !== true) {

                $this->addError($result . '<br>');

            }

        }

        return $this;
    }

    private function addError(string $message):void {

        $this->errors[$this->errorKey] .= $message;

    }

    public function getErrors():array|bool {

        if (array_filter($this->errors)) {

            return $this->errors;
            
        }
        
        return false;

    }

}