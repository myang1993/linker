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
        $query = Project::find()->joinWith('customer as c', true, 'LEFT JOIN')
            ->innerJoinWith('advisers as a', true)->innerJoinWith('boffins as b', true);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pagesize' => 200,
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'project.id' => $this->id,
            'project.customer_id' => $this->customer_id,
            'project.status' => $this->status,
            'project.second' => $this->second,
            'project.date' => $this->date,
            'project.fee_time' => $this->fee_time,
            'a.name_zh' => $this->adviser_name,
        ]);

        $query->andFilterWhere(['like', 'project.name', $this->name]);
        $query->andFilterWhere(['like', 'project.head', $this->head]);
        $query->andFilterWhere(['<', 'project.status', 10]);
        $query->andFilterWhere(['like', 'c.name', $this->customer_name]);
        $query->andFilterWhere(['like', 'participants', $this->participants]);
        $query->andFilterWhere(['like', 'adviser.name_zh', $this->adviser_name]);
        $query->andFilterWhere(['like', 'b.name_zh', $this->boffin_name]);

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
