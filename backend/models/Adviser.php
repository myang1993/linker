<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%adviser}}".
 *
 * @property int $id
 * @property string $name_zh 中文名
 * @property string $name_en 英文名
 * @property int $source_type 来源类型（关联表adviser_source）
 * @property string $referee 推荐人
 * @property double $referee_fee 推荐费
 * @property string $mobile_phone
 * @property string $tele_phone 固定电话
 * @property string $email 邮箱
 * @property string $wechat 微信
 * @property string $linkedin 领英
 * @property int $tax_type 税前
 * @property double $fee_phone 电话访谈费率（RMB/H）
 * @property int $fee_phone_type 电话访谈费率类型（1：RMB/H， 2：USD/H）
 * @property double $fee_road 路演访谈费率（RMB/H）
 * @property int $fee_road_type 路演访谈费率类型（1：RMB/H， 2：USD/H）
 * @property double $fee_face 面谈访谈费率（RMB/H）
 * @property int $fee_face_type 面谈访谈费率类型（1：RMB/H， 2：USD/H）
 * @property string $company 所在公司
 * @property string $position 担任的职位
 * @property string $describe 顾问背景
 * @property string $expertise 专业知识
 * @property string $bank_card_name 开户姓名
 * @property string $bank_card_addr 开户行支行
 * @property string $bank_card_no 银行卡号
 * @property string $remark 备注
 * @property string $pay_remark 支付备注
 * @property int $times 合作次数
 * @property string $district 区
 * @property string $city 市
 * @property string $province 省
 * @property string $trade 行业
 * @property string $child_trade 子行业
 * @property string $profile 简历
 * @property string $operator 操作者
 * @property int $update_time 最后更新时间
 *
 * @property Adviser $referee0
 * @property ProjectAdviser[] $projectAdvisers
 * @property Project[] $projects
 */
class Adviser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%adviser}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['source_type', 'fee_phone_type', 'fee_road_type', 'fee_face_type', 'update_time', 'tax_type', 'province'], 'integer'],
            [['mobile_phone'], 'required'],
//            ['mobile_phone', 'match', 'pattern' => '/^1[0-9]{10}$/', 'message' => '{attribute}必须为1开头的11位纯数字'],
//            ['mobile_phone', 'unique'],
            [['referee_fee', 'fee_phone', 'fee_road', 'fee_face'], 'number'],
            [['name_zh', 'name_en', 'referee'], 'string', 'max' => 128],
            [['tele_phone'], 'string', 'max' => 64],
            [['email', 'wechat', 'bank_card_name'], 'string', 'max' => 64],
            [['linkedin', 'company', 'position', 'expertise', 'bank_card_addr', 'remark', 'pay_remark'], 'string', 'max' => 255],
            [['describe', 'profile'], 'string', 'max' => 1024],
            [['bank_card_no'], 'string', 'max' => 32],
            [['update_time'], 'default', 'value' => time()],
            [['district', 'city', 'province', 'trade', 'child_trade'], 'string', 'max' => 50],
            [['operator'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name_zh' => Yii::t('app', 'Chinese Name'),
            'name_en' => Yii::t('app', 'English Name'),
            'source_type' => Yii::t('app', 'Adviser Source'),
            'referee' => Yii::t('app', '推荐人'),
            'referee_fee' => Yii::t('app', '推荐费'),
            'mobile_phone' => Yii::t('app', 'Mobile Phone'),
            'tele_phone' => Yii::t('app', 'Tele Phone'),
            'email' => Yii::t('app', 'E-mail'),
            'wechat' => Yii::t('app', 'Wechat'),
            'linkedin' => Yii::t('app', 'Linkedin'),
            'tax_type' => Yii::t('app', 'Tax Type'),
            'fee_phone' => Yii::t('app', 'Telephone Interview Price'),
            'fee_phone_type' => Yii::t('app', 'Price Type'),
            'fee_road' => Yii::t('app', 'Roadshow Interview Price'),
            'fee_road_type' => Yii::t('app', 'Price Type'),
            'fee_face' => Yii::t('app', 'Face Interview Price'),
            'fee_face_type' => Yii::t('app', 'Price Type'),
            'company' => Yii::t('app', 'Company'),
            'position' => Yii::t('app', 'Position'),
            'describe' => Yii::t('app', 'Background'),
            'expertise' => Yii::t('app', 'Expertise'),
            'bank_card_name' => Yii::t('app', 'Bank Card Name'),
            'bank_card_addr' => Yii::t('app', 'Bank Card Address'),
            'bank_card_no' => Yii::t('app', 'Bank Card No.'),
            'remark' => Yii::t('app', '备注'),
            'pay_remark' => Yii::t('app', '支付备注'),
            'times' => Yii::t('app', '合作次数'),
            'district' => Yii::t('app', '区/县'),
            'city' => Yii::t('app', '市'),
            'province' => Yii::t('app', '省份'),
            'trade' => Yii::t('app', 'Trade'),
            'child_trade' => Yii::t('app', 'Child Trade'),
            'profile' => Yii::t('app', '历史简历'),
            'operator' => Yii::t('app', 'Operator'),
            'update_time' => Yii::t('app', 'Last Time'),
        ];
    }

    /**
     * 价格类型
     *
     * @param integer $type
     * @return void
     */
    public function priceType($type = 0)
    {
        $typeList = [1 => 'RMB/H', 2 => 'USD/H'];

        return $retVal = $type ? $typeList[$type] : $typeList;
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
     * 付费类型
     *
     * @param integer $type
     * @return void
     */
    public function payType($type = '')
    {
        $typeList = [
            'fee_phone' => Yii::t('app', 'Telephone Interview Price'),
            'fee_road' => Yii::t('app', 'Roadshow Interview Price'),
            'fee_face' => Yii::t('app', 'Face Interview Price'),
        ];

        return $retVal = !empty($type) ? $typeList[$type] : $typeList;
    }

    /**
     * 来源类型
     *
     * @param integer $type
     * @return void
     */
    public function SourceType($type = 0)
    {
        $typeList = [1 => '搜索（baidu/Google）', 2 => '招聘网站', 3 => '顾问推荐', 4 => '公司内部推荐', 5 => '其他'];

        return $retVal = $type ? $typeList[$type] : $typeList;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferee0()
    {
        return $this->hasOne(Adviser::className(), ['id' => 'referee']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArea()
    {
        return $this->hasOne(Area::className(), ['id' => 'province']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreaCity()
    {
        return $this->hasOne(Area::className(), ['id' => 'city']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrade()
    {
        return $this->hasOne(Trade::className(), ['id' => 'trade']);
    }

    public function getChildTrade()
    {
        return $this->hasOne(Trade::className(), ['id' => 'child_trade']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectAdvisers()
    {
        return $this->hasMany(ProjectAdviser::className(), ['adviser_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['id' => 'project_id'])->viaTable('{{%project_adviser}}', ['adviser_id' => 'id']);
    }

    /**
     * 获取顾问列表
     *
     * @return array
     */
    public function getAdviser()
    {
        $model = $this->find()->select('id,name_zh,company')->limit(100)->all();
        foreach ($model as $key => &$value) {
            $value->name_zh = $value->name_zh . ' ' . $value->company;
        }
        return yii\helpers\ArrayHelper::map($model, 'id', 'name_zh');
    }

    /**
     * 顾问信息
     *
     * @param int $id
     *
     * @return string
     */
    public function getInfo($id,$type ='')
    {
        $model = Adviser::findOne($id);
        if (empty($type)) {
            return !empty($model) ? $model['name_zh'] : null;
        } else {
            return $model;
        }
    }

    /**
     * {@inheritdoc}
     * @return AdviserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdviserQuery(get_called_class());
    }

    /**通过关键字获取顾问列表
     * @param $keyword
     * @return array
     */
    public function getAdviserByKeyWord($keyword)
    {
        $model = $this->find()->select('id,name_zh,company')->where("name_zh like '%{$keyword}%'")->asArray()->all();
        foreach ($model as $key => &$value) {
            $value['text'] = $value['name_zh'] . ' ' . $value['company'];
            unset($value['name_zh']);
            unset($value['company']);
        }
        return $model;
    }
}
