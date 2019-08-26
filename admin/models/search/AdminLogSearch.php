<?php

namespace admin\models\search;

use common\models\table\AdminLog;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AdminLogSearch represents the model behind the search form of `common\models\table\AdminLog`.
 */
class AdminLogSearch extends AdminLog {
	public $begin_time;
	public $end_time;

	public function rules() {
		return [
			[['id', 'admin_id', 'menu_id', 'action', 'record_id'], 'integer'],
			[['content', 'table', 'field', 'origin', 'new', 'create_time', 'update_time', 'begin_time', 'end_time'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function scenarios() {
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
	public function search($params) {
		$query = AdminLog::find();

		// add conditions that should always apply here

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'id' => SORT_DESC,
				],
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
			'admin_id' => $this->admin_id,
			'menu_id' => $this->menu_id,
			'record_id' => $this->record_id,
			'action' => $this->action,
			'create_time' => $this->create_time,
			'update_time' => $this->update_time,
		]);

		$query->andFilterWhere(['like', 'content', $this->content])
			->andFilterWhere(['like', 'table', $this->table])
			->andFilterWhere(['like', 'field', $this->field])
			->andFilterWhere(['like', 'origin', $this->origin])
			->andFilterWhere(['like', 'new', $this->new]);

		$query->andFilterWhere(['>=', 'create_time', $this->begin_time])
			->andFilterWhere(['<', 'create_time', $this->end_time]);

		return $dataProvider;
	}
}
