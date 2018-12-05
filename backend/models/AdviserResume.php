<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "adviser_resume".
 *
 * @property string $id
 * @property string $adviser_id
 * @property string $company 所在公司
 * @property string $position 担任的职位
 * @property string $begin_time
 * @property string $end_time
 * @property string $create_time
 */
class AdviserResume extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'adviser_resume';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['adviser_id', 'company', 'position', 'begin_time'], 'required'],
            [['adviser_id'], 'integer'],
            [['begin_time', 'end_time', 'create_time'], 'safe'],
            [['company', 'position'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'adviser_id' => 'Adviser ID',
            'company' => '所在公司',
            'position' => '担任的职位',
            'begin_time' => '开始时间',
            'end_time' => '结束时间',
            'create_time' => '创建时间',
        ];
    }

    /**
     * {@inheritdoc}
     * @return AdviserResumeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdviserResumeQuery(get_called_class());
    }
}
