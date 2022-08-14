<?php

namespace Src\services\validatorRules;

use Src\interfaces\ValidatorRuleInterface;

class FilenameExtension implements ValidatorRuleInterface {

    public function __construct(

        private array $allowedExtensions

    ){}

    public function validate($subject): bool|string {
        
        $parsed = explode('.', $subject);

        if (! in_array(end($parsed), $this->allowedExtensions)) {

            return 'allowed extensions are ' . implode(', ', $this->allowedExtensions);

        }

        return true;

    }

}