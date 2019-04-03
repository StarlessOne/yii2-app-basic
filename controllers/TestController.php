<?php

namespace app\controllers;

use app\models\Product;
use yii\web\Controller;

class TestController extends Controller
{
    /**
     * Displays test page.
     *
     * @return string
     */
    public function actionIndex()
    {
        $product = new Product();
        $product->category = 'Some category';
        $product->id = 1;
        $product->name = 'First product';
        $product->price = 9001;

        return $this->render('index', ['product' => $product]);
    }
}
