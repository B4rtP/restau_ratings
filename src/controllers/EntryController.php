<?php

namespace Src\controllers;

use Src\core\Controller;
use Src\core\View;
use Src\entities\User;
use Src\services\AccountHandler;
use Src\services\Validator;
use Src\services\validatorRules\ContainsCapital;
use Src\services\validatorRules\ContainsDigit;
use Src\services\validatorRules\ContainsSpecialChar;
use Src\services\validatorRules\NotEmptyOrWhitespace;
use Src\services\validatorRules\LettersNumbersOnly;
use Src\services\validatorRules\MaxLenght;
use Src\services\validatorRules\MinLenght;
use Src\services\validatorRules\StrictMatch;
use Src\services\validatorRules\UniqueRecord;
use Src\services\validatorRules\ValidateEmail;

class EntryController extends Controller {

    public function loginAction() {

        $this->restrictMultipleEntries();

        $this->displayForm('login-form');

    }

    public function registerAction() {

        $this->restrictMultipleEntries();

        $this->displayForm('register-form');

    }

    public function logoutAction() {

        if ($_SESSION['user-id'] ?? false) {

            unset($_SESSION['user-id']);

            $_SESSION['message'] = 'Successfully signed out';
        }

        header('Location:/');
        exit;
    }

    public function loginSubmitAction() {

        $email = $_POST['email'];
        $password = $_POST['password'];

        $account = (new AccountHandler($this->dbc))
        ->accessBy('email', $email, $password);

        if ($account) {

            $_SESSION['user-id'] = $account->id;
            $_SESSION['message'] = 'Successfully signed in';

            header('Location:/');
            exit;

        }

        $data['error'] = 'Email or password is invalid';

        $this->displayForm('login-form', $data);

    }
    
    public function registerSubmitAction() {
        
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $repeatedPwd = $_POST['pwd-repeat'];

        $userEntity = new User($this->dbc);

        $errors = (new Validator())
        
        ->check($username, 'uname')->setRules(
            new NotEmptyOrWhitespace(),
            new MinLenght(5),
            new MaxLenght(15),
            new LettersNumbersOnly(),
            new UniqueRecord($userEntity, 'username', 'username is already taken')
        )
        ->check($email, 'email')->setRules(
            new NotEmptyOrWhitespace(),
            new ValidateEmail(),
            new UniqueRecord($userEntity, 'email', 'email must be unique address')
        )
        ->check($password, 'password')->setRules(
            new NotEmptyOrWhitespace(),
            new MinLenght(8),
            new ContainsCapital(),
            new ContainsDigit(),
            new ContainsSpecialChar()
        )
        ->check($repeatedPwd, 'pwd-repeat')->setRules(
            new NotEmptyOrWhitespace(),
            new StrictMatch($password)
        )
        ->getErrors();

        if ($errors) {

            $data['errors'] = $errors;
            $this->displayForm('register-form', $data);

            return;

        }

        (new AccountHandler($this->dbc))->create($username, $email, $password);
        
        $_SESSION['user-id'] = ($userEntity->select('id')->findBy(['username' => $username]))->id;
        $_SESSION['message'] = 'Successfully registered';

        header('Location:/');
        exit;
    }
    
    private function displayForm($formLayout, $data = []) {

        View::display('default', $data)->setLayout($formLayout);

    }

    private function restrictMultipleEntries() {

        if ($_SESSION['user-id'] ?? false) {

            header('Location:/');
            exit;

        }

    }

}