<?php

namespace backend\models;

/**
 * This is the ActiveQuery class for [[CustomerBoffin]].
 *
 * @see CustomerBoffin
 */
class CustomerBoffinQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CustomerBoffin[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CustomerBoffin|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
