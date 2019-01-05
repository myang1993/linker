<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer_pa_new".
 *
 * @property string $id
 * @property string $application 申请注册联系人
 * @property string $application_address 申请注册联系人地址
 * @property string $study_leadey_address 研究负责人地址
 * @property string $study_leadey 研究负责人
 * @property string $telephone 申请注册联系人电话
 * @property string $leadey_telephone 研究负责人电话
 * @property string $application_email 申请注册联系人电子邮件
 * @property string $leadey__email 研究负责人电子邮件
 * @property string $position 申请人所在单位
 * @property int $page_id
 * @property string $create_time
 */
class CustomerPaNew extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer_pa_new';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['page_id'], 'integer'],
            [['create_time'], 'safe'],
            [['application', 'application_address', 'study_leadey_address', 'study_leadey', 'telephone', 'leadey_telephone', 'application_email', 'position'], 'string', 'max' => 255],
            [['leadey__email'], 'string', 'max' => 1024],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'application' => '申请注册联系人',
            'application_address' => '申请注册联系人地址',
            'study_leadey_address' => '研究负责人地址',
            'study_leadey' => '研究负责人',
            'telephone' => '申请注册联系人电话',
            'leadey_telephone' => '研究负责人电话',
            'application_email' => '申请注册联系人电子邮件',
            'leadey__email' => '研究负责人电子邮件',
            'position' => '申请人所在单位',
            'page_id' => 'Page ID',
            'create_time' => 'Create Time',
        ];
    }

    /**
     * {@inheritdoc}
     * @return CustomerPaNewQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CustomerPaNewQuery(get_called_class());
    }
}
