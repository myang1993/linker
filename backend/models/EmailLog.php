<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "email_log".
 *
 * @property string $id
 * @property string $to_emails 邮件发送人
 * @property string $cc_emails 邮件抄送人
 * @property string $bcc_emails 邮件密送人
 * @property string $content 邮件内容
 * @property int $status 发送状态 1.成功 2.失败
 * @property string $reason 失败原因
 * @property int $create_uid
 * @property string $create_time
 */
class EmailLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'email_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content','to_emails'], 'required'],
            [['content'], 'string'],
            [['status','create_uid'], 'integer'],
            [['create_time'], 'safe'],
            [['to_emails', 'cc_emails', 'bcc_emails', 'reason'], 'string', 'max' => 1024],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'to_emails' => '收件人',
            'cc_emails' => '抄送人',
            'bcc_emails' => '密送',
            'content' => '邮件内容',
            'status' => 'Status',
            'reason' => 'Reason',
            'create_time' => 'Create Time',
        ];
    }
}
