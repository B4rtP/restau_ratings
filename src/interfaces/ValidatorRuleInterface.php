<?php

namespace Src\interfaces;

interface ValidatorRuleInterface {

    public function validate($subject):bool|string;

}