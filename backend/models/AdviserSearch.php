<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Adviser;

/**
 * AdviserSearch represents the model behind the search form of `backend\models\Adviser`.
 */
class AdviserSearch extends Adviser
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%adviser}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'source_type', 'fee_phone_type', 'fee_road_type', 'fee_face_type', 'update_time'], 'integer'],
            [['name_zh', 'name_en', 'mobile_phone', 'tele_phone', 'email', 'wechat', 'linkedin', 'company', 'position', 'describe', 'expertise', 'bank_card_name', 'bank_card_addr', 'bank_card_no', 'remark'], 'safe'],
            [['fee_phone', 'fee_road', 'fee_face'], 'number'],
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
        $query = Adviser::find();

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
            'source_type' => $this->source_type,
            'fee_phone' => $this->fee_phone,
            'fee_phone_type' => $this->fee_phone_type,
            'fee_road' => $this->fee_road,
            'fee_road_type' => $this->fee_road_type,
            'fee_face' => $this->fee_face,
            'fee_face_type' => $this->fee_face_type,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'name_zh', $this->name_zh])
            ->andFilterWhere(['like', 'name_en', $this->name_en])
            ->andFilterWhere(['like', 'mobile_phone', $this->mobile_phone])
            ->andFilterWhere(['like', 'tele_phone', $this->tele_phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'wechat', $this->wechat])
            ->andFilterWhere(['like', 'linkedin', $this->linkedin])
            ->andFilterWhere(['like', 'company', $this->company])
            ->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'describe', $this->describe])
            ->andFilterWhere(['like', 'expertise', $this->expertise])
            ->andFilterWhere(['like', 'bank_card_name', $this->bank_card_name])
            ->andFilterWhere(['like', 'bank_card_addr', $this->bank_card_addr])
            ->andFilterWhere(['like', 'bank_card_no', $this->bank_card_no])
            ->andFilterWhere(['like', 'trade', $this->trade])
            ->andFilterWhere(['like', 'child_trade', $this->child_trade])
            ->andFilterWhere(['like', 'province', $this->province])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'remark', $this->remark]);

        return $dataProvider;
    }
}
