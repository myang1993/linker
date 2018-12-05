<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[AdviserResume]].
 *
 * @see AdviserResume
 */
class AdviserResumeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AdviserResume[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AdviserResume|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
