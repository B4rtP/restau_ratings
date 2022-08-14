<?php

namespace Src\services;

use PDO;
use Src\entities\User;

class AccountHandler {

    public function __construct(

        private PDO $dbc

    ) {}

    public function create(
        string $username, string $email, string $password, string|int $privileges=0):void {

            $pwdHash = password_hash($password, PASSWORD_DEFAULT);

            (new User($this->dbc))->save([
                'username' => $username,
                'email' => $email,
                'password' => $pwdHash,
                'privileges' => $privileges
            ]);

    }

    public function accessBy(string $column, string $field, string $password):object|bool {

        if ($record = (new User($this->dbc))->findBy([$column => $field])) {

            if (password_verify($password, $record->password)) {

                return $record;

            }
        }

        return false;

    }
}