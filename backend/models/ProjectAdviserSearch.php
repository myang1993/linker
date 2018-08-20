<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ProjectAdviser;

/**
 * ProjectAdviserSearch represents the model behind the search form of `backend\models\ProjectAdviser`.
 */
class ProjectAdviserSearch extends ProjectAdviser
{
    public $project_id;
    public $project_name;
    public $project_date;
    public $customer;
    public $boffin;
    public $talk_time;
    public $cost_time;
    public $adviser_name;
    public $adviser_position;
    public $adviser_company;
    public $unit_price;
    public $unit_type;
    public $customer_income;
    public $contain_tax;
    public $billing;
    public $project_type;
    public $mark;
    public $project_manager;
    public $adviser_fee;
    public $adviser_bank_name;
    public $adviser_bank_card;
    public $adviser_bank_addr;
    public $adviser_pay;
    public $referee;
    public $referee_fee;
    public $referee_bank_name;
    public $referee_bank_card;
    public $referee_bank_addr;
    public $referee_pay;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'project_id', 'adviser_id', 'state', 'date'], 'integer'],
            [['remark', 'pay_remark', 'project_name', 'adviser_name', 'project_date', 'referee_pay', 'adviser_pay', 'customer'], 'safe'],
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
        $query = ProjectAdviser::find()->joinWith('project as t0', true, 'LEFT JOIN')->joinWith('adviser as t1', true, 'LEFT JOIN');

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
        $query->andFilterWhere([
            'id' => $this->id,
            'project_id' => $this->project_id,
            'adviser_id' => $this->adviser_id,
            'state' => $this->state,
            'date' => $this->date,
            'referee_pay' => $this->referee_pay,
            'adviser_pay' => $this->adviser_pay,
            't0.status' => 4,
        ]);

        $query->andFilterWhere(['like', 't0.name', $this->project_name]);
        $query->andFilterWhere(['like', 't1.name_zh', $this->adviser_name]);
        $query->andFilterWhere(['like', 'remark', $this->remark]);
        $query->andFilterWhere(['like', 'pay_remark', $this->pay_remark]);

        $dataProvider->setSort([
            'attributes' => [
                'project_id' => [
                    'asc' => ['t0.id' => SORT_ASC],
                    'desc' => ['t0.id' => SORT_DESC],
                ],
                'project_name' => [
                    'asc' => ['t0.name' => SORT_ASC],
                    'desc' => ['t0.name' => SORT_DESC],
                ],
                'adviser_name' => [
                    'asc' => ['t1.name_zh' => SORT_ASC],
                    'desc' => ['t1.name_zh' => SORT_DESC],
                ],
            ]
        ]);
        return $dataProvider;
    }

    public function updateSearch($project_id)
    {
        $query = ProjectAdviser::find()->joinWith('project as t0', true, 'LEFT JOIN')->joinWith('adviser as t1', true, 'LEFT JOIN');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pagesize' => 20,
            ]
        ]);

        // grid filtering conditions
        $query->andFilterWhere([
            'project_id' => $project_id,
        ]);

        return $dataProvider;
    }
}
