<?php

namespace admin\models\search;

use common\models\table\Level;
use Yii;
use yii\base\Model;
use common\models\table\Finance;
use yii\db\Expression;

/**
 * FinanceSearch represents the model behind the search form of `common\models\table\Finance`.
 */
class ChartSearch extends Finance
{
	public $type;
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id', 'admin_id', 'level_id', 'cat_id', 'status'], 'safe'],
			[['cost', 'type'], 'safe'],
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
		$query = Finance::find()
			->alias('f')

			->leftJoin(['l' => Level::tableName()], ['l.id' => new Expression('f.level_id')])
			->where(['f.status' => 1]);
			//->groupBy(['f.level_id']);

		$admin_id = Yii::$app->user->getId();
		if (Yii::$app->authManager->getRolesByUser($admin_id) != 'admin' && $admin_id != 1) {
			$query->andWhere(['admin_id' => $admin_id]);
		}

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

		$sum_query = clone $query;
		$sum_query->select(['sum_cost' => 'SUM(cost)']);
		$sum_cost = $sum_query->scalar();

		switch ($this->type){
			case 1:
				$query->select(['cost_total' => 'SUM(cost)', 'l.name']);
				$query->groupBy(['f.level_id']);
				break;
			case 2:
				$query->select(['cost_total' => 'SUM(cost)', 'month' => "DATE_FORMAT(date,'%Y-%m')"]);
				$query->groupBy(['month']);
				break;
			default:
				$query->select(['cost_total' => 'SUM(cost)', 'l.name']);
				$query->groupBy(['f.level_id']);
				break;
		}

		$info = $query->asArray()->all();

		return ['info' => $info, 'sum_cost' => $sum_cost, 'type' => $this->type];
	}
}
