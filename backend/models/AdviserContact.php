<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "adviser_contact".
 *
 * @property int $adviser_id
 * @property string $info
 * @property string $type
 * @property string $created_at
 */
class AdviserContact extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'adviser_contact';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['adviser_id', 'info', 'type'], 'required'],
            [['adviser_id'], 'integer'],
            [['type'], 'string'],
            [['created_at'], 'safe'],
            [['info'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'adviser_id' => Yii::t('app', 'Adviser ID'),
            'info' => Yii::t('app', 'Info'),
            'type' => Yii::t('app', 'Type'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    public function getListByAdviser($adviser_id)
    {
        $ret = static::find()->where(['adviser_id' => $adviser_id])->asArray()->all();
        return $ret;
    }
}
