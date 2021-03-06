<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Project;

/**
 * ProjectSearch represents the model behind the search form of `backend\models\Project`.
 */
class ProjectSearch extends Project
{
    public $start = [];
    public $create = [];
    public $customer_name;
    public $adviser_name;
    public $boffin_name;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'customer_id', 'status', 'second', 'date', 'fee_time'], 'integer'],
            [['name', 'head', 'customer_name', 'start', 'participants', 'adviser_name', 'boffin_name'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'start' => Yii::t('app', 'Start'),
            'customer_name' => Yii::t('app', 'Customers'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Project::find()->joinWith('customer as c', true, 'LEFT JOIN');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pagesize' => 20,
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions

        if (!empty($this->adviser_name)) {
            $project_id_arr = ProjectAdviser::find()->select('project_adviser.adviser_id,project_adviser.project_id,a.name_zh')->andFilterWhere(['like', 'a.name_zh', $this->adviser_name])->innerJoinWith('adviser as a', true)->asArray()->all();
            $project_id_arr = array_unique(array_column($project_id_arr, 'project_id'));
            if (empty($project_id_arr)) {
                $project_adviser_id = [0];
            } else {
                $project_adviser_id = $project_id_arr;
            }
        }

        if (!empty($this->boffin_name)) {
            $project_id_arr = ProjectBoffin::find()->select('project_boffin.boffin_id,project_boffin.project_id,a.name_zh')->andFilterWhere(['like', 'a.name_zh', $this->boffin_name])->innerJoinWith('boffin as a', true)->asArray()->all();
            $project_id_arr = array_unique(array_column($project_id_arr, 'project_id'));
            if (empty($project_id_arr)) {
                $project_boffin_id = [0];
            } else {
                $project_boffin_id = $project_id_arr;
            }
        }

        if (isset($project_adviser_id) && isset($project_boffin_id)) {
            $query->andFilterWhere(['in', 'project.id', array_intersect($project_adviser_id, $project_boffin_id)]);
        } else if (isset($project_adviser_id)) {
            $query->andFilterWhere(['in', 'project.id', $project_adviser_id]);
        } else if (isset($project_boffin_id)) {
            $query->andFilterWhere(['in', 'project.id', $project_boffin_id]);
        }
        $query->andFilterWhere([
            'project.id' => $this->id,
            'project.customer_id' => $this->customer_id,
            'project.status' => $this->status,
            'project.second' => $this->second,
            'project.date' => $this->date,
            'project.fee_time' => $this->fee_time,
        ]);

        $query->andFilterWhere(['like', 'project.name', $this->name]);
        $query->andFilterWhere(['like', 'project.head', $this->head]);
        $query->andFilterWhere(['<', 'project.status', 10]);
        $query->andFilterWhere(['like', 'c.name', $this->customer_name]);
        $query->andFilterWhere(['like', 'participants', $this->participants]);

        if (!empty($this->start)) {
            if (!empty($this->start[0])) {
                $query->andFilterCompare('start_time', strtotime($this->start[0]), '>=');//起始时间;
            }

            if (!empty($this->start[1])) {
                $query->andFilterCompare('start_time', strtotime($this->start[1]), '<=');//起始时间;
            }
        }

        $query->orderBy(['id' => SORT_DESC]);
//        echo $query->createCommand()->getRawSql();exit;
        return $dataProvider;
    }


    public function updateSearch($id)
    {
        $query = Project::find()->select('project.name,project_adviser.id,a.name_zh')->innerJoinWith('advisers as a', true);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->andFilterWhere(['project.id'=>$id]);
        return $dataProvider;
    }
}
