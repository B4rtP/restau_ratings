<?php

namespace Src\controllers;

use Src\core\Controller;
use Src\core\Entity;
use Src\core\View;
use Src\entities\Restaurant;
use Src\entities\Review;
use Src\enums\OpinionResult;
use Src\services\OpinionMiner;
use Src\services\Validator;
use Src\services\validatorRules\MinLenght;
use Src\services\validatorRules\NotEmptyOrWhitespace;

class ReviewController extends Controller {

    private object|bool $restaurantObj;

    public function beforeAction() {

        $this->restaurantObj = (new Restaurant($this->dbc))
        ->select('id', 'name', 'image', 'url_name')
        ->findBy([
            'url_name' => array_shift($this->urlParams)
        ]);

        if (! ($_SESSION['user-id'] ?? false) || ! ($this->restaurantObj)) {

            header('Location:/');
            exit;

        }

        return true;

    }

    public function indexAction() {
        
        $review = $this->findReviewRecord();

        $layout = 'new-review-form';

        if ($review) {

            $data['review'] = $review;
            $layout = 'already-reviewed';

        }

        $this->display($layout, $data ?? []);
        
    }

    public function submitNewReviewAction() {

        $header = $_POST['header'];
        $content = $_POST['content'];
        $restaurantId = $_POST['restaurant-id'];

        if ($data['errors'] = $this->validateReview($header, $content)) {

            return $this->display('new-review-form', $data);

        }

        $opinionValue = $this->mineReviewOpinion($header, $content);

        (new Review($this->dbc))->save([
            'restaurant_id' => $restaurantId,
            'user_id' => $_SESSION['user-id'],
            'header' => $header,
            'content' => $content,
            'result' => $opinionValue,
        ]);

        $_SESSION['message'] = 'Review successfully published';

        header('Location:/my_review/' . $this->restaurantObj->url_name);
        exit;
    }

    public function displayEditFormAction() {

        $data['oldReview'] = $this->findReviewRecord();

        $this->display('edit-review-form', $data);

    }

    public function updateReviewAction() {

        $header = $_POST['new-header'];
        $content = $_POST['new-content'];
        $reviewId = $_POST['review-id'];

        if ($data['errors'] = $this->validateReview($header, $content)) {

            $data['oldReview'] = $this->findReviewRecord();
            return $this->display('edit-review-form', $data);

        }

        $newOpinionValue = $this->mineReviewOpinion($header, $content);

        (new Review($this->dbc))->updateBy('id', $reviewId, [
            'header' => $header,
            'content' => $content,
            'result' => $newOpinionValue
        ]);

        $_SESSION['message'] = 'Review successfully updated';

        header('Location:/my_review/' . $this->restaurantObj->url_name);
        exit;

    }

    public function deleteReviewAction() {

        $reviewId = $_POST['review-id'];

        (new Review($this->dbc))->deleteBy('id', $reviewId);

        header('Location:/my_review/' . $this->restaurantObj->url_name);
        exit;

    }

    private function mineReviewOpinion(string $header, string $content):int|float|null {

        $reviewResult = (new OpinionMiner($this->dbc))->fromInput($header, $content);

        return OpinionResult::from($reviewResult->value)->getArithmeticValue();

    }

    private function validateReview(string $header, string $content):array|bool {

        return (new Validator())
        ->check($header, 'header')->setRules(new NotEmptyOrWhitespace(), new MinLenght(5))
        ->check($content, 'content')->setRules(new NotEmptyOrWhitespace(), new MinLenght(10))
        ->getErrors();

    }

    private function findReviewRecord():object|bool {

        return Entity::fromView($this->dbc, 'reviews_list')
        ->select('header', 'content', 'review_id')
        ->findBy([
            'user_id' => $_SESSION['user-id'],
            'url_name' => $this->restaurantObj->url_name
        ]);

    }

    private function display(string $layout, array $data = []) {

        $data['restaurant'] = $this->restaurantObj;

        View::display('review-page', $data)->setLayout($layout);

    }

}