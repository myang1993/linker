<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%project_adviser}}".
 *
 * @property int $id
 * @property int $project_id 项目ID
 * @property int $adviser_id 顾问ID
 * @property int $state 访谈状态（not contacted,contacted,recommended,arranged,rescheduled,completed,deleted）
 * @property int $selector_id 安排人员
 * @property string $remark 沟通备注
 * @property string $pay_remark 付款备注
 * @property int $date 访谈日期
 * @property int $duration 访谈时长
 * @property string $cost 顾问成本
 * @property string $hour 访谈时长
 * @property string $pay_type 付费类型
 * @property int $fee 访谈费率
 * @property int $fee_type 费率类型
 * @property double $fee_rate 顾问倍率
 * @property int $adviser_pay 专家成本是否已支出
 * @property int $referee_pay 推荐费是否已支出
 * @property int $bill_out 账单是否已出
 * @property string $customer_fee 收客户费用
 *
 * @property Project $project
 * @property Adviser $adviser
 * @property Admin $admin
 */
class ProjectAdviser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%project_adviser}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['date', 'filter', 'filter' => function () {
                if (is_numeric($this->date)) {
                    return $this->date;
                } else {
                    return strtotime($this->date);
                }
            }],
            [['project_id', 'selector_id', 'adviser_id', 'state', 'duration', 'fee', 'fee_type', 'adviser_pay', 'referee_pay', 'bill_out'], 'integer'],
            [['fee_rate'], 'match', 'pattern' => '/^\d+\.{0,1}\d{0,1}$/', 'message' => '{attribute}只能包含小数点后一位'],
            [['fee_rate'], 'default', 'value' => 1],
            [['selector_id'], 'default', 'value' => 0],
            [['state'], 'default', 'value' => 1],
            [['remark'], 'string', 'max' => 1024],
            [['pay_remark'], 'string', 'max' => 256],
            [['pay_type'], 'string', 'max' => 50],
            [['customer_fee'],'safe'],
            [
                ['hour','cost'],
                'required',
                'when' => function($model) {
                    return $model->state== 6;
                },
                'whenClient' => "function (attribute, value) {
                    return $('.update_cls').val() == '6';
                }",
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'project_id' => Yii::t('app', '项目编号'),
            'adviser_id' => Yii::t('app', '顾问'),
            'selector_id' => Yii::t('app', '安排人员'),
            'state' => Yii::t('app', '访谈状态'),
            'remark' => Yii::t('app', '沟通备注'),
            'pay_remark' => Yii::t('app', '付款备注'),
            'date' => Yii::t('app', '访谈日期'),
            'duration' => Yii::t('app', '访谈时长(分钟)'),
            'hour' => Yii::t('app', '访谈时长(小时)'),
            'cost' => Yii::t('app', '顾问成本'),
            'pay_type' => Yii::t('app', '访谈类型'),
            'fee' => Yii::t('app', '访谈费率'),
            'fee_type' => Yii::t('app', '费率类型'),
            'fee_rate' => Yii::t('app', '顾问倍率'),
            'adviser_pay' => Yii::t('app', '专家成本是否已支出'),
            'referee_pay' => Yii::t('app', '推荐费是否已支出'),
            'bill_out' => Yii::t('app', '账单是否已出'),
            'customer_fee' => Yii::t('app', '收客户费用'),
        ];
    }

    /**
     * 状态类型
     * @param int $rate
     * @return array|mixed
     */
    public function feeRate($rate = 0)
    {
        $typeList = ['1' => '1', '1.5' => '1.5', '2' => '2', '2.5' => '2.5', '3' => '3', '3.5' => '3.5', '4' => '4', '4.5' => '4.5', '5' => '5'];
        return $retVal = $rate ? $typeList[$rate] : $typeList;
    }

    /**
     * 状态类型
     * @param int $type
     * @param int $mode
     * @return array|mixed
     */
    public function stateType($type = 0, $mode = 1)
    {
        $typeList = [1 => 'not contacted', 2 => 'contacted', 3 => 'recommended', 4 => 'arranged', 5 => 'rescheduled', 6 => 'completed', 7 => 'deleted'];
        if ($mode == 2) {
            $length = count($typeList) - ($type-1);
            return array_slice($typeList, $type-1, $length, true);
        } else {
            return $retVal = $type ? $typeList[$type] : $typeList;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
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
    public function getAdmin()
    {
        return $this->hasOne(Admin::className(), ['id' => 'selector_id']);
    }

    /**
     * {@inheritdoc}
     * @return ProjectAdviserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectAdviserQuery(get_called_class());
    }

    /**
     * 添加专家到项目中
     * @param $adviser_id
     * @param $project_id
     */
    public function addAdviserProject($adviser_id, $project_id)
    {
        $adviserInfo = (new Adviser())->getInfo($adviser_id, 'all');
        if (!$adviserInfo) {
            return;
        }
        $this->project_id = $project_id;
        $this->adviser_id = $adviser_id;
        $this->date = date('Y-m-d H:i:s');
        $this->pay_type = 'fee_phone';
        $this->fee = $adviserInfo->fee_phone;
        $this->fee_type = $adviserInfo->fee_phone_type;
        if (!$this->save()) {
            Yii::error('批量添加错误:' . json_encode($this->getErrors(), JSON_UNESCAPED_UNICODE));
        }
    }

    public function getInfo($id)
    {
        $model = new Adviser();
        $info = $model->getInfo($id, 'all');
        $type = $model->priceType();
        $tax_type = $model->taxType();
        $data = [
            $info['fee_face'] => '(' . $tax_type[$info['tax_type']] . ') ' . Yii::t('app', 'Face Interview Price') . $info['fee_face'] . '(' . $type[$info['fee_face_type']] . ')',
            $info['fee_phone'] => '(' . $tax_type[$info['tax_type']] . ') ' . Yii::t('app', 'Telephone Interview Price') . $info['fee_phone'] . '(' . $type[$info['fee_phone_type']] . ')',
            $info['fee_road'] => '(' . $tax_type[$info['tax_type']] . ') ' . Yii::t('app', 'Roadshow Interview Price') . $info['fee_road'] . '(' . $type[$info['fee_road_type']] . ')',
        ];
        return $data;

    }

    public function addSPace($number)
    {
        $number = str_replace(' ', '', $number);
        $len = strlen($number);
        $space = [];
        for ($i = 0; $i < $len; $i = $i + 4) {
            $space[] = substr($number, $i, 4);
        }
        return implode(' ', $space);
    }
}
