<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Shared tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'title',
            'description:text',
            [
                'label' => 'Shared with',
                'value' => function (\app\models\Task $model) {
                    $users = $model->getAccessedUsers()->select('username')->column();
                    $usersCount = count($users);
                    if ($usersCount > 10) {
                        return "$usersCount users";
                    }
                    return join(', ', $users);
                }
            ],
            'created_at:datetime',
            'updated_at:datetime',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {share}',
                'buttons' => [
                    'share' => function ($url, $model, $key) {
                        $icon = \yii\bootstrap\Html::icon('share');
                        return Html::a($icon, ['task-user/create', 'taskId' => $model->id]);
                    }
                ],
            ],
        ],
    ]); ?>


</div>
