<?php

namespace admin\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\table\Chowmatistic;

/**
 * ChowmatisticSearch represents the model behind the search form of `common\models\table\Chowmatistic`.
 */
class ChowmatisticSearch extends Chowmatistic
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cur_id', 'cat_id', 'open_interest'], 'integer'],
            [['profit', 'commission'], 'number'],
            [['remark', 'offset_time', 'create_time', 'update_time'], 'safe'],
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

    public function search($params)
    {
        $query = Chowmatistic::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'offset_time' => SORT_DESC,
					'id' => SORT_DESC
				]
			],
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
            'cur_id' => $this->cur_id,
            'cat_id' => $this->cat_id,
            'open_interest' => $this->open_interest,
            'profit' => $this->profit,
            'commission' => $this->commission,
        ]);

		$query->timeRangeFilter('offset_time', $this->offset_time);
        $query->andFilterWhere(['like', 'remark', $this->remark]);

		$sum_query = clone $query;
		$sum_query->select(['sum_profit' => 'SUM(profit2)', 'sum_commission' => 'SUM(commission2)']);
		$sum = $sum_query->asArray()->one();

		$data = [
			'dataProvider' => $dataProvider,
			'sum_profit' => $sum['sum_profit'],
			'sum_commission' => $sum['sum_commission'],
		];

        return $data;
    }
}
