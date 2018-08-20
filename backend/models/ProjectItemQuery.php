<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[\backend\models\ProjectItem]].
 *
 * @see \backend\models\ProjectItem
 */
class ProjectItemQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \backend\models\ProjectItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\ProjectItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
