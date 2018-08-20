<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ProjectItem;

/**
 * ProjectItemSearch represents the model behind the search form of `backend\models\ProjectItem`.
 */
class ProjectItemSearch extends ProjectItem
{
    //这里声明被关联字段 trade_name 是自建属性，指 trade 表中的 name
    public $trade_name;
    public $tradeParent_name;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'trade_parent_id', 'trade_id'], 'integer'],
            [['name'], 'safe'],
            [['trade_name'], 'safe'],
            [['tradeParent_name'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Project Name'),
            'trade_name' => Yii::t('app', 'Child Trade'),
            'tradeParent_name' => Yii::t('app', 'Trade'),
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
        $query = ProjectItem::find()->joinWith('trade AS t0', true, 'LEFT JOIN')->joinWith('tradeParent AS t1', true, 'LEFT JOIN');

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
            'trade_parent_id' => $this->trade_parent_id,
            'trade_id' => $this->trade_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 't0.name', $this->trade_name]);
        $query->andFilterWhere(['like', 't1.name', $this->tradeParent_name]);

        $dataProvider->setSort([
            'attributes' => [
                'name' => [
                    'asc' => ['name' => SORT_ASC],
                    'desc' => ['name' => SORT_DESC],
                ],
                'trade_name' => [
                    'asc' => ['t0.name' => SORT_ASC],
                    'desc' => ['t0.name' => SORT_DESC],
                ],
                'tradeParent_name' => [
                    'asc' => ['t1.name' => SORT_ASC],
                    'desc' => ['t1.name' => SORT_DESC],
                ],
            ]
        ]);

        return $dataProvider;
    }
}
