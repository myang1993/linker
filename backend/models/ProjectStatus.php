<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%project_status}}".
 *
 * @property int $id 状态id
 * @property string $name 状态名
 *
 * @property ProjectItem[] $projectItems
 */
class ProjectStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%project_status}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '状态id'),
            'name' => Yii::t('app', '状态名'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectItems()
    {
        return $this->hasMany(ProjectItem::className(), ['status' => 'id']);
    }

    /**
    * Undocumented function
    *
    * @param [type] $pid
    * @return void
    */
   public function getStatusList()
   {
       $model = $this->find()->all();
       return yii\helpers\ArrayHelper::map($model, 'id', 'name');
   }

    /**
     * {@inheritdoc}
     * @return ProjectStatusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectStatusQuery(get_called_class());
    }
}
