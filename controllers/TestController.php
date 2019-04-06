<?php

namespace app\controllers;

use app\models\Product;
use yii\web\Controller;

class TestController extends Controller {
    /**
     * Displays test page.
     *
     * @return string
     */
    public function actionIndex() {

        $someVar = \Yii::$app->test->showProp();
        $product = new Product();
        $product->category = 'Some category';
        $product->id = $someVar;
        $product->name = 'First product';
        $product->price = 9001;

        return $this->render('index', ['product' => $product]);
    }
}
