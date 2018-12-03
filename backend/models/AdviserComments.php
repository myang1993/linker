<?php

namespace app\models;

use backend\models\Admin;
use Yii;

/**
 * This is the model class for table "adviser_comments".
 *
 * @property string $id
 * @property string $comments
 * @property int $comment_uid 备注人
 * @property int $adviser_id 备注人
 * @property string $create_time
 */
class AdviserComments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'adviser_comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment_uid','adviser_id'], 'integer'],
            [['create_time'], 'safe'],
            [['comments'], 'string', 'max' => 1024],
            [['comments', 'comment_uid'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'adviser_id'=>'专家',
            'comments' => '备注',
            'comment_uid' => '操作人',
            'create_time' => '时间',
        ];
    }

    /**
     * {@inheritdoc}
     * @return AdviserCommentsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdviserCommentsQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdmin()
    {
        return $this->hasOne(Admin::className(), ['id' => 'comment_uid']);
    }

    public static function getNewComments($adviser_id)
    {
        $ret = static::find()->where(['adviser_id' => $adviser_id])->orderBy(['id' => SORT_DESC])->one();
        return $ret;
    }
}
