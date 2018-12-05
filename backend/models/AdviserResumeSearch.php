<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AdviserResume;

/**
 * AdviserResumeSearch represents the model behind the search form of `app\models\AdviserResume`.
 */
class AdviserResumeSearch extends AdviserResume
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'adviser_id'], 'integer'],
            [['company', 'position', 'begin_time', 'end_time', 'create_time'], 'safe'],
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
        $query = AdviserResume::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'adviser_id' => $this->adviser_id,
            'begin_time' => $this->begin_time,
            'end_time' => $this->end_time,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'company', $this->company])
            ->andFilterWhere(['like', 'position', $this->position]);

        return $dataProvider;
    }
}
