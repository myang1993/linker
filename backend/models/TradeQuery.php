<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[\backend\models\Trade]].
 *
 * @see \backend\models\Trade
 */
class TradeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \backend\models\Trade[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\Trade|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
