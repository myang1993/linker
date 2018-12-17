<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%customer_boffin}}".
 *
 * @property int $id ID
 * @property int $customer_id 客户ID
 * @property string $name_zh 中文名
 * @property string $name_en 英文名
 * @property string $position 职位
 * @property string $email 邮箱
 * @property string $mobile_phone 手机
 * @property string $tele_phone 固定电话
 * @property string $wechat 微信
 * @property string $linkedin 领英
 *
 * @property Customer $customer
 * @property ProjectBoffin[] $projectBoffins
 * @property Project[] $projects
 */
class CustomerBoffin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%customer_boffin}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id'], 'integer'],
            [['name_zh', 'name_en'], 'string', 'max' => 60],
            [['position'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 50],
            [['mobile_phone', 'tele_phone'], 'string', 'max' => 16],
            [['wechat', 'linkedin'], 'string', 'max' => 128],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '研究员ID'),
            'customer_id' => Yii::t('app', '客户ID'),
            'name_zh' => Yii::t('app', '中文名'),
            'name_en' => Yii::t('app', '英文名'),
            'position' => Yii::t('app', '职位'),
            'email' => Yii::t('app', '邮箱'),
            'mobile_phone' => Yii::t('app', '手机'),
            'tele_phone' => Yii::t('app', '固定电话'),
            'wechat' => Yii::t('app', '微信'),
            'linkedin' => Yii::t('app', '领英'),
        ];
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
    public function getProjectBoffins()
    {
        return $this->hasMany(ProjectBoffin::className(), ['boffin_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['id' => 'project_id'])->viaTable('{{%project_boffin}}', ['boffin_id' => 'id']);
    }

    /**
     * 研究员列表
     *
     * @param integer $id
     * @return void
     */
    public function getCustomerBoffins($id=0)
    {
        $model = $this->findAll(['customer_id'=>$id]);
        return yii\helpers\ArrayHelper::map($model, 'id', 'name_zh');
    }

    /**
     * {@inheritdoc}
     * @return CustomerBoffinQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CustomerBoffinQuery(get_called_class());
    }
}
