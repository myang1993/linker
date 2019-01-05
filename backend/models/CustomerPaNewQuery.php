<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[CustomerPaNew]].
 *
 * @see CustomerPaNew
 */
class CustomerPaNewQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CustomerPaNew[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CustomerPaNew|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
