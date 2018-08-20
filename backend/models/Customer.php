<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%customer}}".
 *
 * @property int $id 客户ID
 * @property string $name 公司名称
 * @property string $describe 公司描述
 * @property string $website 公司官网
 * @property string $pay_style 计费方式
 * @property string $remark tips
 * @property int $time_type 1.大于15分钟 按1小时 2：15分钟到30分钟，按半小时
 * @property int $tax_type 纳税类型
 * @property double $fee_phone 电话访谈费率（RMB/H）
 * @property int $fee_phone_type 电话访谈费率类型（1：RMB/H， 2：USD/H）
 * @property double $fee_road 路演访谈费率（RMB/H）
 * @property int $fee_road_type 路演访谈费率类型（1：RMB/H， 2：USD/H）
 * @property double $fee_face 面谈访谈费率（RMB/H）
 * @property int $fee_face_type 面谈访谈费率类型（1：RMB/H， 2：USD/H）
 * @property double $unit_price 单价
 * @property int $unit_type 1：RMB，2：USD
 *
 * @property CustomerBoffin[] $customerBoffins
 * @property Project[] $projects
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%customer}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['time_type', 'tax_type', 'fee_phone_type', 'fee_road_type', 'fee_face_type', 'unit_type'], 'integer'],
            [['fee_phone', 'fee_road', 'fee_face', 'unit_price'], 'number'],
            [['name', 'describe', 'website', 'remark'], 'string', 'max' => 255],
            [['pay_style'], 'string', 'max' => 1024],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '客户ID'),
            'name' => Yii::t('app', '公司名称'),
            'describe' => Yii::t('app', '公司描述'),
            'website' => Yii::t('app', '公司官网'),
            'pay_style' => Yii::t('app', '计费方式'),
            'remark' => Yii::t('app', 'tips'),
            'projects' => Yii::t('app', '项目数量'),
            'customerBoffins' => Yii::t('app', '研究员数量'),
            'time_type' => Yii::t('app', '分类'),
            'tax_type' => Yii::t('app', '纳税类型'),
            'fee_phone' => Yii::t('app', '电话访谈费率'),
            'fee_phone_type' => Yii::t('app', '电话访谈费率类型'),
            'fee_road' => Yii::t('app', '路演访谈费率'),
            'fee_road_type' => Yii::t('app', '路演访谈费率类型'),
            'fee_face' => Yii::t('app', '面谈访谈费率'),
            'fee_face_type' => Yii::t('app', '面谈访谈费率类型'),
            'unit_price' => Yii::t('app', '单价'),
            'unit_type' => Yii::t('app', '货币'),
        ];
    }

    /**
     * 纳税类型
     *
     * @param integer $type
     * @return void
     */
    public function taxType($type = 0)
    {
        $typeList = [1 => '税前', 2 => '税后'];

        return $retVal = $type ? $typeList[$type] : $typeList;
    }

    /**
     * 货币类型
     * @param integer $type
     * @return void
     */
    public function unitType($type = 0)
    {
        $typeList = [1 => 'RMB', 2 => 'USD'];

        return $retVal = $type ? $typeList[$type] : $typeList;
    }

    /**
     * 时间分类
     * @param integer $type
     * @return void
     */
    public function timeType($type = 0)
    {
        $typeList = [1 => '大于15分钟，按1小时', 2 => '15分钟到30分钟，按半小时'];

        return $retVal = $type ? $typeList[$type] : $typeList;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerBoffins()
    {
        return $this->hasMany(CustomerBoffin::className(), ['customer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['customer_id' => 'id']);
    }

    /**
     * 获取客户列表
     *
     * @return array
     */
    public function getCustomers()
    {
        $model = $this->find()->all();
        return yii\helpers\ArrayHelper::map($model, 'id', 'name');
    }

    /**
     * {@inheritdoc}
     * @return CustomerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CustomerQuery(get_called_class());
    }
}
