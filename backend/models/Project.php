<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%project}}".
 *
 * @property int $id
 * @property int $type 项目类型 1电话访谈，2面谈，3路演，4数据，5会议，6考察
 * @property string $name 项目名
 * @property int $customer_id 客户ID（公司）
 * @property string $participants 参与者
 * @property string $head 负责人
 * @property int $status 项目当前状态（1.Proposal、2.kickoff、3.Onhold、4.Done）
 * @property int $start_time 项目开始时间
 * @property int $create_time 项目创建时间
 * @property int $second 访谈时长
 * @property int $date 访谈日期
 * @property int $fee_time 客户收费时长
 * @property double $unit_price 单价
 * @property double $pay_type 访谈类型
 * @property int $unit_type 1：RMB，2：USD
 *
 * @property Customer $customer
 * @property ProjectAdviser[] $projectAdvisers
 * @property Adviser[] $advisers
 * @property ProjectBoffin[] $projectBoffins
 * @property CustomerBoffin[] $boffins
 * @property ProjectStaff[] $projectStaff
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%project}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['start_time', 'filter', 'filter' => function () {
                return strtotime($this->start_time);
            }],
            ['create_time', 'filter', 'filter' => function () {
                return strtotime($this->create_time);
            }],
            ['participants', 'required'],
            ['participants', 'filter', 'filter' => function () {
                return implode("，", $this->participants);
            }],
            [['type', 'customer_id', 'status', 'unit_type'], 'integer'],
            [['unit_price'], 'number'],
            [['name', 'customer_id'], 'required'],
            [['name', 'head'], 'string', 'max' => 255],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
            ['pay_type','safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', '项目类型'),
            'name' => Yii::t('app', '项目名'),
            'customer_id' => Yii::t('app', '客户'),
            'participants' => Yii::t('app', '参与者'),
            'head' => Yii::t('app', '负责人'),
            'status' => Yii::t('app', '状态'),
            'start_time' => Yii::t('app', '开始时间'),
            'create_time' => Yii::t('app', '创建时间'),
            'second' => Yii::t('app', '访谈时长'),
            'date' => Yii::t('app', '访谈日期'),
            'fee_time' => Yii::t('app', '客户收费时长'),
            'unit_price' => Yii::t('app', '客户单价'),
            'unit_type' => Yii::t('app', '类型'),
            'pay_type' => Yii::t('app', '访谈类型'),
        ];
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
     * 状态类型
     * @param integer $type
     * @return array|string
     */
    public function projectType($type = 0)
    {
        $typeList = [1 => '电话访谈', 2 => '面谈', 3 => '路演', 4 => '数据', 5 => '会议', 6 => '考察'];
        return $retVal = $type ? $typeList[$type] : $typeList;
    }

    /**
     * 状态类型
     * @param integer $type
     * @return array|string
     */
    public function statusType($type = 0)
    {
        $typeList = [1 => 'Proposal', 2 => 'kickoff', 3 => 'Onhold', 4 => 'Done'];
        return $retVal = $type ? $typeList[$type] : $typeList;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectAdvisers()
    {
        return $this->hasMany(ProjectAdviser::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvisers()
    {
        return $this->hasMany(Adviser::className(), ['id' => 'adviser_id'])->viaTable('{{%project_adviser}}', ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectBoffins()
    {
        return $this->hasMany(ProjectBoffin::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBoffins()
    {
        return $this->hasMany(CustomerBoffin::className(), ['id' => 'boffin_id'])->viaTable('{{%project_boffin}}', ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectStaff()
    {
        return $this->hasMany(ProjectStaff::className(), ['project_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ProjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectQuery(get_called_class());
    }

    /**
     * 根据关键字查询项目列表
     * @param $keyword
     */
    public function getProjectList($keyword)
    {
        $model = $this->find()->select('id,name')->where("name like '%{$keyword}%'")->where(['<>','status',4])->asArray()->all();
        return $model;
    }

    /**
     * 获取顾问列表
     *
     * @return array
     */
    public function getProject()
    {
        $model = $this->find()->select('id,name')->where(['<>','status',4])->all();
        return yii\helpers\ArrayHelper::map($model, 'id', 'name');
    }
}
