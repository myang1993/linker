<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%project_adviser_customer}}".
 *
 * @property int $id
 * @property int $project_id 项目ID
 * @property int $adviser_id 顾问ID
 * @property int $customer_id 客户ID
 *
 * @property ProjectItem $project
 * @property Adviser $adviser
 * @property Customer $customer
 */
class ProjectAdviserCustomer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%project_adviser_customer}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id', 'adviser_id', 'customer_id'], 'integer'],
            [['project_id', 'adviser_id', 'customer_id'], 'required'],
            [['project_id', 'adviser_id', 'customer_id'], 'unique', 'targetAttribute' => ['project_id', 'adviser_id', 'customer_id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectItem::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['adviser_id'], 'exist', 'skipOnError' => true, 'targetClass' => Adviser::className(), 'targetAttribute' => ['adviser_id' => 'id']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'project_id' => Yii::t('app', '项目ID'),
            'adviser_id' => Yii::t('app', '顾问ID'),
            'customer_id' => Yii::t('app', '客户ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(ProjectItem::className(), ['id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdviser()
    {
        return $this->hasOne(Adviser::className(), ['id' => 'adviser_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\ProjectAdviserCustomerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\ProjectAdviserCustomerQuery(get_called_class());
    }
}
