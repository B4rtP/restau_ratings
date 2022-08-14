<?php

namespace Src\controllers;

use Src\core\Controller;
use Src\core\Entity;
use Src\core\View;
use Src\services\Formatter;
use Src\services\helpers\PrettyDateTime;
use Src\services\helpers\ToPercent;

class RestaurantController extends Controller {

    private object|bool $restaurantObj;

    public function beforeAction() {

        $this->restaurantObj = Entity::fromView($this->dbc, 'restaurants_list')
        ->findBy([
            'rr_url' => array_shift($this->urlParams)
        ]);

        if (! $this->restaurantObj) {

            header('Location:/');
            exit;

        }

        return true;

    }

    public function indexAction() {

        

        $reviews = Entity::fromView($this->dbc, 'reviews_list')
        ->findAllBy(['restaurant_id' => $this->restaurantObj->rr_id]);

        Formatter::convert($this->restaurantObj)->use(
            new ToPercent('rev_average')
        )
        ->convert($reviews)->use(
            new ToPercent('result'),
            new PrettyDateTime('latest_alteration')
        );

        $data['restaurant'] = $this->restaurantObj;
        $data['reviews'] = $reviews;
        
        $currentUserId = $_SESSION['user-id'] ?? false;

        $data['userLogged'] = boolval($currentUserId);
        $data['userReviewed'] = in_array($currentUserId, array_column($reviews, 'user_id'));

        View::display('default', $data)->setLayout('single-restaurant');
    }

}