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
    public $province_name;
    public $city_name;
    public $trade_name;
    public $child_trade_name;
    public $mode; //1.模糊匹配
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
            [['id', 'source_type', 'fee_phone_type', 'fee_road_type', 'fee_face_type', 'update_time','mode'], 'integer'],
            [['name_zh', 'name_en', 'mobile_phone', 'tele_phone', 'email', 'wechat', 'linkedin', 'company', 'position', 'describe', 'expertise', 'bank_card_name', 'bank_card_addr', 'bank_card_no', 'remark','province_name','city_name','province','city','trade_name','child_trade_name','trade','child_trade','city_name','profile','mode'], 'safe'],
            [['fee_phone', 'fee_road', 'fee_face','mode'], 'number'],
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
        $query = Adviser::find()->joinWith('area as t_province', true, 'LEFT JOIN')->joinWith('areaCity as t_city', true, 'LEFT JOIN')->joinWith('trade as t_trade', true, 'LEFT JOIN')->joinWith('childTrade as t_child_trade', true, 'LEFT JOIN');

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
            'province' => $this->province,
            'city' => $this->city,
            'trade' => $this->trade,
            'child_trade'=>$this->child_trade,
        ]);

        if (isset($params['mode']) && $params['mode'] == 1) {
            $query->orFilterWhere(['like', 'name_zh', $this->name_zh])
                ->orFilterWhere(['like', 'name_en', $this->name_en])
                ->orFilterWhere(['like', 'mobile_phone', $this->mobile_phone])
                ->orFilterWhere(['like', 'tele_phone', $this->tele_phone])
                ->orFilterWhere(['like', 'email', $this->email])
                ->orFilterWhere(['like', 'wechat', $this->wechat])
                ->orFilterWhere(['like', 'linkedin', $this->linkedin])
                ->orFilterWhere(['like', 'company', $this->company])
                ->orFilterWhere(['like', 'position', $this->position])
                ->orFilterWhere(['like', 'describe', $this->describe])
                ->orFilterWhere(['like', 'expertise', $this->expertise])
                ->orFilterWhere(['like', 'bank_card_name', $this->bank_card_name])
                ->orFilterWhere(['like', 'bank_card_addr', $this->bank_card_addr])
                ->orFilterWhere(['like', 'bank_card_no', $this->bank_card_no])
                ->orFilterWhere(['like', 't_province.name', $this->province_name])
                ->orFilterWhere(['like', 't_city.name', $this->city_name])
                ->orFilterWhere(['like', 't_trade.name', $this->trade_name])
                ->orFilterWhere(['like', 't_child_trade.name', $this->child_trade_name])
                ->orFilterWhere(['like', 'profile', $this->profile])
                ->orFilterWhere(['like', 'remark', $this->remark]);
        } else {
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
                ->andFilterWhere(['like', 't_province.name', $this->province_name])
                ->andFilterWhere(['like', 't_city.name', $this->city_name])
                ->andFilterWhere(['like', 't_trade.name', $this->trade_name])
                ->andFilterWhere(['like', 't_child_trade.name', $this->child_trade_name])
                ->andFilterWhere(['like', 'profile', $this->profile])
                ->andFilterWhere(['like', 'remark', $this->remark]);
        }

        $dataProvider->setSort([
            'attributes' => [
                'province_name' => [
                    'asc' => ['province' => SORT_ASC],
                    'desc' => ['province' => SORT_DESC],
                ],
                'city_name' => [
                    'asc' => ['city' => SORT_ASC],
                    'desc' => ['city' => SORT_DESC],
                ],
                'trade_name' => [
                    'asc' => ['trade' => SORT_ASC],
                    'desc' => ['trade' => SORT_DESC],
                ],
                'child_trade_name' => [
                    'asc' => ['child_trade' => SORT_ASC],
                    'desc' => ['child_trade' => SORT_DESC],
                ],
            ]
        ]);
//        echo $query->createCommand()->getRawSql();exit;
        return $dataProvider;
    }
}
