<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%project_item}}".
 *
 * @property int $id
 * @property string $name 项目名
 * @property int $trade_parent_id 行业父ID
 * @property int $trade_id 项目所属行业ID
 * @property string $head 负责人
 * @property int $status 项目当前状态
 * @property string $start_time 项目开始时间
 * @property string $create_time 项目创建时间
 *
 * @property ProjectAdviserCustomer[] $projectAdviserCustomers
 * @property ProjectStaff[] $projectStaff
 * @property Trade $trade
 * @property Trade $tradeParent
 * @property ProjectStatus $status0
 */
class ProjectItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%project_item}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'trade_id', 'trade_parent_id'], 'required'],
            [['trade_parent_id', 'trade_id', 'status'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['start_time', 'create_time'], 'safe'],
            [['trade_id'], 'exist', 'skipOnError' => true, 'targetClass' => Trade::className(), 'targetAttribute' => ['trade_id' => 'id']],
            [['trade_parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Trade::className(), 'targetAttribute' => ['trade_parent_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectStatus::className(), 'targetAttribute' => ['status' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Project Name'),
            'trade_id' => Yii::t('app', 'Child Trade'),
            'trade_parent_id' => Yii::t('app', 'Trade'),
            'head' => Yii::t('app', 'Head'),
            'status' => Yii::t('app', 'Status'),
            'start_time' => Yii::t('app', 'Start Time'),
            'create_time' => Yii::t('app', 'Create Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectAdviserCustomers()
    {
        return $this->hasMany(ProjectAdviserCustomer::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectStaff()
    {
        return $this->hasMany(ProjectStaff::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrade()
    {
        return $this->hasOne(Trade::className(), ['id' => 'trade_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTradeParent()
    {
        return $this->hasOne(Trade::className(), ['id' => 'trade_parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(ProjectStatus::className(), ['id' => 'status']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\ProjectItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\ProjectItemQuery(get_called_class());
    }
}
