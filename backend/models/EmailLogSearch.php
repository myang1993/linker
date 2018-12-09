<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EmailLog;

/**
 * EmailLogSearch represents the model behind the search form of `app\models\EmailLog`.
 */
class EmailLogSearch extends EmailLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['to_emails', 'cc_emails', 'bcc_emails', 'context', 'reason', 'create_time'], 'safe'],
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
        $query = EmailLog::find();

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
            'status' => $this->status,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'to_emails', $this->to_emails])
            ->andFilterWhere(['like', 'cc_emails', $this->cc_emails])
            ->andFilterWhere(['like', 'bcc_emails', $this->bcc_emails])
            ->andFilterWhere(['like', 'context', $this->context])
            ->andFilterWhere(['like', 'reason', $this->reason]);

        return $dataProvider;
    }
}
