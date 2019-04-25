<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Task]].
 *
 * @see Task
 */
class TaskQuery extends \yii\db\ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return TaskQuery
     */
    public function byCreator($userId)
    {
        return $this->andWhere(['creator_id' => $userId]);
    }

    /**
     * {@inheritdoc}
     * @return Task[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Task|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
