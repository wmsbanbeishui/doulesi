<?php

namespace admin\models;

use common\models\table\Admin as AdminTalbe;
use yii\data\ActiveDataProvider;

class Admin extends AdminTalbe
{
	const STATUS_ENABLE = 1;
	const STATUS_DISABLE = 0;

	public function search($params)
	{
		$query = self::find();
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => '100',
			],
			'sort' => [
				'defaultOrder' => [
					'id' => SORT_DESC,
				],
			],
		]);

		return $dataProvider;
	}
}
