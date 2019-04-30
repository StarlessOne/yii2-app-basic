<?php

use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Task */
/* @var $dataProvider ActiveDataProvider */
/* @var $taskId int */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'My tasks', 'url' => ['my']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="task-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description:text',
            'creator_id',
            'updater_id',
            'created_at',
            'updated_at',
        ],
    ]); ?>

    <?php if ($dataProvider): ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'label' => 'username',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->getUser()->one()->username;
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{unshare}',
                'buttons' => [
                    'unshare' => function ($url, $model, $key) {
                        $icon = \yii\bootstrap\Html::icon('remove');
                        return Html::a($icon, ['task-user/delete', 'id' => $model->id],
                            ['data' => [
                                'confirm' => 'Are you sure that you want to hide the task from that user?',
                                'method' => 'post']
                            ]);
                    }
                ],
            ],
        ]
    ]);
    endif; ?>

</div>
