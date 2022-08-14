<?php

namespace Src\admin\controllers;

use Src\core\Controller;
use Src\core\View;
use Src\services\AccountHandler;

class EntryController extends Controller {

    public function indexAction() {

        $this->displayForm();

    }

    public function loginSubmitAction() {

        $username = $_POST['username'];
        $password = $_POST['password'];

        $account = (new AccountHandler($this->dbc))->accessBy('username', $username, $password);

        if ($account->privileges ?? 0 === 1) {

            $_SESSION['admin'] = true;

            header('Location:/admin/dashboard');
            exit;

        }

        $data['error'] = 'invalid username or password';
        $this->displayForm($data);

    }

    private function displayForm(array $data = []) {

        View::display('login', $data);
        exit;

    }

    public function logoutAction() {

        if ($_SESSION['admin'] ?? false) {

            unset($_SESSION['admin']);

        }

        header('Location:/');
        exit;

    }

}