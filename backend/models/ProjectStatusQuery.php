<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[ProjectStatus]].
 *
 * @see ProjectStatus
 */
class ProjectStatusQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProjectStatus[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProjectStatus|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
