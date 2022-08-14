<?php

namespace Src\services\validatorRules;

use PDO;
use Src\core\Entity;
use Src\interfaces\ValidatorRuleInterface;

class UniqueRecord implements ValidatorRuleInterface {

    public function __construct(
        
        private Entity $entity,
        private string $column,
        private string $message
    ) {}

    public function validate($subject): bool|string {
        
        if ($this->entity->findBy([$this->column => $subject])) {

            return $this->message;

        }

        return true;

    }


}