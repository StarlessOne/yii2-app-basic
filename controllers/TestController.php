<?php

namespace app\controllers;

use app\models\Product;
use yii\db\Query;
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

    public function actionInsert() {
        \Yii::$app->db->createCommand()
            ->insert('user',
                ['username' => 'user3',
                    'password_hash' => 'someHash3',
                    'auth_key' => 'someKey3',
                    'creator_id' => 42,
                    'created_at' => time()
                ])
            ->execute();
        \Yii::$app->db->createCommand()->batchInsert('task',
            ['title', 'description', 'creator_id', 'created_at'], [
                ['task1', 'desc1', '1', time()],
                ['task2', 'desc2', '2', time()],
                ['task3', 'desc3', '3', time()],
            ])->execute();
    }

    public function actionSelect() {
        $query = new Query();
        $data = $query->from('user')->where('id=1')->one();
        var_dump($data);

        $query = new Query();
        $data = $query->from('user')->where('id>1')->orderBy('username')->all();
        var_dump($data);

        $query = new Query();
        $data = $query->from('user')->count('id');
        var_dump($data);
    }
}
