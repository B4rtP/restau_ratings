<?php

namespace Src\controllers;

use Src\core\Controller;
use Src\core\View;
use Src\entities\AnonymousEntity;
use Src\services\Formatter;
use Src\services\helpers\DateTimeFormatter;
use Src\services\helpers\PercentFormatter;

class MainController extends Controller {

    public function indexAction() {

        $restaurants = AnonymousEntity::fromView($this->dbc, 'restaurants_list')->findAll();

        Formatter::convert($restaurants)->use(

            new PercentFormatter('rev_average'),
            new DateTimeFormatter('rev_newest')
        );
        
        $data['restaurants'] = $restaurants;

        View::display('default', $data)->setLayout('main');

    }

}