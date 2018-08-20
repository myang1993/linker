<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[\backend\models\ProjectAdviserCustomer]].
 *
 * @see \backend\models\ProjectAdviserCustomer
 */
class ProjectAdviserCustomerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \backend\models\ProjectAdviserCustomer[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\ProjectAdviserCustomer|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
