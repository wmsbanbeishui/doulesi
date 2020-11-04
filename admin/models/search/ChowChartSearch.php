<?php

namespace admin\models\search;

use common\models\table\Currency;
use Yii;
use yii\base\Model;
use common\models\table\Chowmatistic;
use yii\db\Expression;

/**
 * FinanceSearch represents the model behind the search form of `common\models\table\Finance`.
 */
class ChowChartSearch extends Chowmatistic
{
	public $type;
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id', 'cur_id', 'cat_id', 'open_interest', 'profit'], 'safe'],
			[['commission', 'remark'], 'safe'],
			[['offset_time', 'remark', 'create_time', 'update_time'], 'safe'],
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
		$query = Chowmatistic::find()
			->alias('c')
			->select(['c.offset_time', 'cur.name', 'profit', 'commission', 'cur_id'])
			->leftJoin(['cur' => Currency::tableName()], ['cur.id' => new Expression('c.cur_id')])
			->orderBy(['c.offset_time' => SORT_ASC]);

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
			'cur_id' => $this->cur_id,
			'cat_id' => $this->cat_id,
			'open_interest' => $this->open_interest,
			'profit' => $this->profit,
			'commission' => $this->commission,
			'create_time' => $this->create_time,
			'update_time' => $this->update_time,
		]);

		$query->timeRangeFilter('offset_time', $this->offset_time);

		$info = $query->asArray()->all();

		return $info;
	}
}
