<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%area}}".
 *
 * @property int $id 子Id
 * @property int $pid 父Id
 * @property string $name 行政名
 */
class Area extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%area}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pid', 'name'], 'required'],
            [['id', 'pid'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'pid' => Yii::t('app', 'Pid'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @param $pid
     * @return array
     */
    public function getAreaList($pid=0)
    {
        $model = $this->findAll(array('pid'=>$pid));
        return yii\helpers\ArrayHelper::map($model, 'id', 'name');
    }

    /**
     * {@inheritdoc}
     * @return AreaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AreaQuery(get_called_class());
    }
}
