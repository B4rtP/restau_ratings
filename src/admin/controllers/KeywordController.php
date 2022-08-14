<?php

namespace Src\admin\controllers;

use Src\core\Controller;
use Src\core\View;
use Src\entities\Keyword;
use Src\services\Validator;
use Src\services\validatorRules\NotEmptyOrWhitespace;
use Src\services\validatorRules\UniqueRecord;

class KeywordController extends Controller {

    public function indexAction() {

        $this->display();

    }

    public function addKeywordAction() {

        $kwEntity = new Keyword($this->dbc);

        $keyword = $_POST['keyword'];
        $type = $_POST['type'];

        $error = (new Validator)
        ->check($keyword, 'kw')
        ->setRules(
            new NotEmptyOrWhitespace(),
            new UniqueRecord($kwEntity, 'keyword', 'keyword "' . $keyword . '" is already set'))
        ->getErrors();

        if ($error) {

            $data['error'] = $error;
            $this->display($data);

            return;
        }

        $kwEntity->save([
            'keyword' => $keyword,
            'type' => $type === 'positive' ? 1 : 0,
        ]);

        $this->display();

    }

    public function deleteKeywordAction() {

        $kwId = $_POST['id'];

        (new Keyword($this->dbc))->deleteBy('id', $kwId);

        header('Location:/admin/keywords');
        exit;

    }

    private function display(array $data = []) {

        $kwEntity = (new Keyword($this->dbc))->select('keyword', 'id');

        $data['positiveKeywords'] = $kwEntity->findAllBy(['type' => 1]);

        $data['negativeKeywords'] = $kwEntity->findAllBy(['type' => 0]);

        View::display('dashboard', $data)->setLayout('keywords');

    }

}