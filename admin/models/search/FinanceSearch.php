<?php

namespace admin\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\table\Finance;

/**
 * FinanceSearch represents the model behind the search form of `common\models\table\Finance`.
 */
class FinanceSearch extends Finance
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'admin_id', 'level_id', 'cat_id', 'status'], 'safe'],
            [['cost'], 'safe'],
            [['date', 'remark', 'create_time', 'update_time'], 'safe'],
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     */
    public function search($params)
    {
        $query = Finance::find();

        // add conditions that should always apply here



        $this->load($params);

		if (!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			echo '111';exit;
		}

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'admin_id' => $this->admin_id,
            'level_id' => $this->level_id,
            'cat_id' => $this->cat_id,
            'cost' => $this->cost,
            'status' => $this->status,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

		$query->timeRangeFilter('date', $this->date);

        $query->andFilterWhere(['like', 'remark', $this->remark]);

		$sum_query = clone $query;
		$sum_query->select(['sum_cost' => 'SUM(cost)']);
		$sum_cost = $sum_query->scalar();

		//echo $query->createCommand()->getRawSql();exit;

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => ['pageSize' => 15],
			'sort' => ['defaultOrder' => ['date' => SORT_DESC, 'id' => SORT_DESC]],
		]);

        return ['dataProvider' => $dataProvider, 'sum_cost' => $sum_cost];
    }
}
