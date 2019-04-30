<?php

namespace app\controllers;

use Yii;
use app\models\Task;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
{
    public $defaultAction = 'my';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all user created tasks.
     * @return mixed
     */
    public function actionMy()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Task::find()->byCreator(Yii::$app->user->id),
        ]);

        return $this->render('my', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all user shared tasks.
     * @return mixed
     */
    public function actionShared()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Task::find()
                ->byCreator(Yii::$app->user->id)
                ->innerJoinWith(Task::RELATION_TASK_USERS),
        ]);

        return $this->render('shared', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all tasks that were shared with current user.
     * @return mixed
     */
    public function actionAccessed()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Task::find()
                ->where(['<>', 'task.creator_id', Yii::$app->user->id])
                ->andWhere(['=', 'task_user.user_id', Yii::$app->user->id])
                ->JoinWith(Task::RELATION_TASK_USERS),
        ]);

        ;

        return $this->render('accessed', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if ($id === Yii::$app->user->id) {
            $dataProvider = new ActiveDataProvider([
                'query' => $model->getTaskUsers()
            ]);
        } else {
            $dataProvider = false;
        }


        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Task();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('success', 'A task has been created successfully');
            return $this->redirect('my');
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws ForbiddenHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (!$model || $model->creator_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('Access denied!');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('success', 'A task has been updated successfully');
            return $this->redirect(['my']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws ForbiddenHttpException if the model cannot be found
     * @throws \Exception|\Throwable in case delete failed.
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (!$model || $model->creator_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('Access denied!');
        }

        $this->findModel($id)->delete();
        Yii::$app->session->addFlash('success', 'A task has been deleted successfully');

        return $this->redirect(['my']);
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
