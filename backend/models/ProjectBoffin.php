<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%project_boffin}}".
 *
 * @property int $id
 * @property int $project_id 项目ID
 * @property int $boffin_id 顾问ID
 *
 * @property Project $project
 * @property CustomerBoffin $boffin
 */
class ProjectBoffin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%project_boffin}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id', 'boffin_id'], 'integer'],
            [['project_id', 'boffin_id'], 'unique', 'targetAttribute' => ['project_id', 'boffin_id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['boffin_id'], 'exist', 'skipOnError' => true, 'targetClass' => CustomerBoffin::className(), 'targetAttribute' => ['boffin_id' => 'id']],
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
            'boffin_id' => Yii::t('app', '研究员ID'),
        ];
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
    public function getBoffin()
    {
        return $this->hasOne(CustomerBoffin::className(), ['id' => 'boffin_id']);
    }

    /**
     * {@inheritdoc}
     * @return ProjectBoffinQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectBoffinQuery(get_called_class());
    }
}
