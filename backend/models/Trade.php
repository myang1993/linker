<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%trade}}".
 *
 * @property int $id 行业ID
 * @property int $parent_id 父ID
 * @property string $name 行业名称
 *
 * @property ParentTrade $parentTrade
 * @property Adviser[] $advisers
 * @property Adviser[] $advisers0
 * @property Customer[] $customers
 * @property Customer[] $customers0
 * @property ProjectItem[] $projectItems
 * @property ProjectItem[] $projectItems0
 */
class Trade extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%trade}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '行业ID'),
            'parent_id' => Yii::t('app', '父行业'),
            'name' => Yii::t('app', '子行业'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentTrade()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvisers()
    {
        return $this->hasMany(Adviser::className(), ['trade_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvisers0()
    {
        return $this->hasMany(Adviser::className(), ['trade_parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomers()
    {
        return $this->hasMany(Customer::className(), ['trade_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomers0()
    {
        return $this->hasMany(Customer::className(), ['trade_parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectItems()
    {
        return $this->hasMany(ProjectItem::className(), ['trade_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectItems0()
    {
        return $this->hasMany(ProjectItem::className(), ['trade_parent_id' => 'id']);
    }

    /**
     * Undocumented function
     *
     * @param [type] $pid
     * @return void
     */
    public function getTradeList($pid)
    {
        $model = $this->findAll(['parent_id'=>$pid]);
        return yii\helpers\ArrayHelper::map($model, 'id', 'name');
    }

    /**
     * {@inheritdoc}
     * @return \app\models\TradeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\TradeQuery(get_called_class());
    }
}
