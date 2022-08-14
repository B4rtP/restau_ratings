<?php

namespace Src\interfaces;

interface HelperInterface {

    public function __construct(string|int $key);

    public function run(mixed $field):mixed;


}