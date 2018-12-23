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
    public $start_date;
    public $end_date;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['adviser_id', 'state'], 'integer'],
            [['pay_remark', 'project_name', 'adviser_name', 'referee_pay', 'adviser_pay', 'customer', 'start_date', 'end_date', 'bill_out'], 'safe'],
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
            'state' => 6,
        ]);
        if ($this->customer) {
            $customer_id_arr = Customer::find()->select('id')->orFilterWhere(['like', 'name', $this->customer])->asArray()->all();
            if (empty($customer_id_arr)) {
                $customer_id_arr = [0];
            } else {
                $customer_id_arr = array_column($customer_id_arr, 'id');
            }
        }

        if (isset($customer_id_arr)) {
            $query->andFilterWhere(['in', 't0.customer_id', $customer_id_arr]);
        }

        if ($this->bill_out) {
            $query->andFilterWhere(['bill_out' => $this->bill_out]);
        }
        if ($this->adviser_pay) {
            $query->andFilterWhere(['adviser_pay' => $this->adviser_pay]);
        }
        if ($this->referee_pay) {
            $query->andFilterWhere(['referee_pay' => $this->referee_pay]);
        }
        $query->andFilterWhere(['like', 't0.name', $this->project_name]);
        $query->andFilterWhere(['like', 't1.name_zh', $this->adviser_name]);
        $query->andFilterWhere(['like', 'remark', $this->remark]);
        $query->andFilterWhere(['like', 'pay_remark', $this->pay_remark]);
        if (!empty($this->start_date)) {
            $query->andFilterCompare('project_adviser.date', strtotime($this->start_date), '>=');
        }
        if (!empty($this->end_date)) {
            $query->andFilterCompare('project_adviser.date', strtotime($this->end_date), '<=');
        }

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
        $query->orderBy(['id' => SORT_DESC]);
//        echo $query->createCommand()->getRawSql();exit;
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

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'project_name' => Yii::t('app', '项目名称'),
            'adviser_name' => Yii::t('app', '顾问'),
            'adviser_pay' => Yii::t('app', '专家成本已出'),
            'referee_pay' => Yii::t('app', '推荐费已出'),
            'bill_out' => Yii::t('app', '账单已出'),
        ];
    }
}
