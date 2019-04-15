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
        $product->id = $someVar;
        $product->name = 'Fir';
        $product->price = 9001;

        $product->validate();

        return $this->render('index', ['product' => $product]);
    }
}
