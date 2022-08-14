<?php

namespace Src\controllers;

use Src\core\Controller;
use Src\core\Entity;
use Src\core\View;
use Src\enums\MatchMode;
use Src\services\Formatter;
use Src\services\helpers\PrettyDateTime;
use Src\services\helpers\ToPercent;

class MainController extends Controller {

    private Entity $entity;

    public function beforeAction() {

        $this->entity = Entity::fromView($this->dbc,'restaurants_list');

        return true;

    }

    public function indexAction() {

        $restaurants = $this->entity->findAll();

        $this->formatAndDisplay($restaurants);
    }

    public function searchRestaurantsAction() {

        $input = $_POST['searchfield'];

        $restaurants = $this->entity->findMatches([
            'rr_name',
            'rr_cuisine',
            'rr_address'
        ], explode(' ', $input), MatchMode::ANY);

        if (! $restaurants) {

            $_SESSION['message'] = 'Restaurants not found';

            header('Location:/');
            exit;
        }

        $this->formatAndDisplay($restaurants);

    }

    private function formatAndDisplay(array $restaurantObjs) {

        Formatter::convert($restaurantObjs)->use(

            new ToPercent('rev_average'),
            new PrettyDateTime('rev_newest')
        );

        $data['restaurants'] = $restaurantObjs;

        View::display('default', $data)->setLayout('main');

    }

}