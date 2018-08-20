<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%project_staff}}".
 *
 * @property int $id
 * @property int $project_id 项目ID
 * @property int $staff_id 员工ID
 *
 * @property Project $project
 */
class ProjectStaff extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%project_staff}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id', 'staff_id'], 'integer'],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
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
            'staff_id' => Yii::t('app', '员工ID'),
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
     * {@inheritdoc}
     * @return ProjectStaffQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectStaffQuery(get_called_class());
    }
}
