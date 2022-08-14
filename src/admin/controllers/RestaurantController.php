<?php

namespace Src\admin\controllers;

use Src\core\Controller;
use Src\core\View;
use Src\entities\Restaurant;
use Src\services\ImageHandlerFacade;
use Src\services\UploadHandler;
use Src\services\Validator;
use Src\services\validatorRules\FilenameExtension;
use Src\services\validatorRules\LettersOnly;
use Src\services\validatorRules\NotEmptyOrWhitespace;
use Src\services\validatorRules\NumbersOnly;
use Src\services\validatorRules\UrlFriendly;

class RestaurantController extends Controller {

    public function indexAction() {
        
        $this->display();

    }

    public function addRestaurantAction() {

        $name = $_POST['name'];
        $urlName = $_POST['url-name'];
        $address = $_POST['address'];
        $cuisine = $_POST['cuisine'];
        $image = $_FILES['image'];
        $imageBlur = $_POST['blur'];

        $errors = (new Validator())
        ->check($name, 'name')->setRules(
            new NotEmptyOrWhitespace()
        )
        ->check($urlName, 'url-name')->setRules(
            new NotEmptyOrWhitespace(),
            new UrlFriendly()
        )
        ->check($address, 'address')->setRules(
            new NotEmptyOrWhitespace()
        )
        ->check($cuisine, 'cuisine')->setRules(
            new NotEmptyOrWhitespace(),
            new LettersOnly()
        )
        ->check($image['name'], 'image')->setRules(
            new FilenameExtension(['jpg', 'png'])
        )
        ->check($imageBlur, 'blur')->setRules(
            new NotEmptyOrWhitespace(),
            new NumbersOnly()
        )
        ->getErrors();

        if ($errors) {

            $data['errors'] = $errors;
            return $this->display($data);

        }

        $newFileName = UploadHandler::from($image)->saveWithUniqueName(UPLOAD_PATH);

        ImageHandlerFacade::open(UPLOAD_PATH . $newFileName)
        ->reduceMaxSize(MAX_IMAGE_WIDTH, MAX_IMAGE_HEIGHT)
        ->applyBlur($imageBlur)
        ->save(RESTAURANTS_IMAGES . $newFileName);

        (new Restaurant($this->dbc))->save([
            'name' => $name,
            'url_name' => $urlName,
            'address' => $address,
            'cuisine' => $cuisine,
            'image' => $newFileName
        ]);

        header('Location:/admin/restaurants');
        exit;
    }

    public function deleteRestaurantAction() {

        $restaurantId = $_POST['id'];

        $restaurant = new Restaurant($this->dbc);

        $restaurantObj = $restaurant->select('image')->findBy(['id' => $restaurantId]);

        $restaurant->deleteBy('id', $restaurantId);

        unlink(RESTAURANTS_IMAGES . $restaurantObj->image);
        unlink(UPLOAD_PATH . $restaurantObj->image);

        header('Location:/admin/restaurants');
        exit;

    }

    private function display(array $data = []) {

        $data['restaurants'] = (new Restaurant($this->dbc))
        ->select('id', 'name', 'address', 'cuisine', 'image', 'url_name')
        ->findAll();

        View::display('dashboard', $data)->setLayout('restaurants');

    }

}