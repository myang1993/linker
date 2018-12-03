<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AdviserComments;

/**
 * AdviserCommentsSearch represents the model behind the search form of `app\models\AdviserComments`.
 */
class AdviserCommentsSearch extends AdviserComments
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'comment_uid','adviser_id'], 'integer'],
            [['comments', 'create_time'], 'safe'],
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
        $query = AdviserComments::find();

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
            'comment_uid' => $this->comment_uid,
            'adviser_id' => $this->adviser_id,
            'create_time' => $this->create_time,
        ]);

        $query->orderBy(['id' => SORT_DESC]);

        $query->andFilterWhere(['like', 'comments', $this->comments]);
//                echo $query->createCommand()->getRawSql();exit;

        return $dataProvider;
    }
}
