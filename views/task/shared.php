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
                'template' => '{view} {update} {delete} {unshare}',
                'buttons' => [
                    'unshare' => function ($url, $model, $key) {
                        $icon = \yii\bootstrap\Html::icon('remove');
                        return Html::a($icon, ['task-user/delete-all', 'taskId' => $model->id],
                            ['data' => [
                                'confirm' => 'Are you sure you want to unshare this task?',
                                'method' => 'post']
                            ]);

                    }
                ],
            ],
        ],
    ]); ?>


</div>
