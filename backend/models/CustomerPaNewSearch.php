<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CustomerPaNew;

/**
 * CustomerPaNewSearch represents the model behind the search form of `app\models\CustomerPaNew`.
 */
class CustomerPaNewSearch extends CustomerPaNew
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'page_id'], 'integer'],
            [['application', 'application_address', 'study_leadey_address', 'study_leadey', 'telephone', 'leadey_telephone', 'application_email', 'leadey__email', 'position', 'create_time'], 'safe'],
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
        $query = CustomerPaNew::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pagesize' => 30,
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
            'page_id' => $this->page_id,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'application', $this->application])
            ->andFilterWhere(['like', 'application_address', $this->application_address])
            ->andFilterWhere(['like', 'study_leadey_address', $this->study_leadey_address])
            ->andFilterWhere(['like', 'study_leadey', $this->study_leadey])
            ->andFilterWhere(['like', 'telephone', $this->telephone])
            ->andFilterWhere(['like', 'leadey_telephone', $this->leadey_telephone])
            ->andFilterWhere(['like', 'application_email', $this->application_email])
            ->andFilterWhere(['like', 'leadey__email', $this->leadey__email])
            ->andFilterWhere(['like', 'position', $this->position]);
        $query->orderBy(['id' => SORT_DESC]);

        return $dataProvider;
    }
}
