<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[Adviser]].
 *
 * @see Adviser
 */
class AdviserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Adviser[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Adviser|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
