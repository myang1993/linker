<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[ProjectBoffin]].
 *
 * @see ProjectBoffin
 */
class ProjectBoffinQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProjectBoffin[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProjectBoffin|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
