<?php

namespace admin\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\table\DoubleEleven;

/**
 * DoubleElevenSearch represents the model behind the search form of `common\models\table\DoubleEleven`.
 */
class DoubleElevenSearch extends DoubleEleven
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['product', 'year', 'create_time', 'update_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * @param $params
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function search($params)
    {
        $query = DoubleEleven::find();

        // add conditions that should always apply here

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            echo '111';exit;
        }

        if (empty($this->year)) {
            //$this->year = date('Y');
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'year' => $this->year,
        ]);

        $query->timeRangeFilter('year', $this->year);

        $query->andFilterWhere(['like', 'product', $this->product]);

        $sum_query = clone $query;
        $sum_query->select(['sum_price' => 'SUM(price)']);
        $sum_price = $sum_query->scalar();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['year' => SORT_DESC, 'id' => SORT_DESC]],
        ]);

        return ['dataProvider' => $dataProvider, 'sum_price' => $sum_price];
    }
}
