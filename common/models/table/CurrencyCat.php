<?php

namespace common\models\table;

use common\models\base\CurrencyCatBase;
use yii\helpers\ArrayHelper;

class CurrencyCat extends CurrencyCatBase
{
	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), [
			'order_index' => '排序'
		]);
	}

	public static function map()
	{
		$query = self::find()->select(['id', 'name'])->orderBy(['order_index' => SORT_DESC]);

		$data = $query->all();
		$map = ArrayHelper::map($data, 'id', 'name');
		return $map;
	}

	public static function getNameById($id) {
		return self::find()->select(['name'])->where(['id' => $id])->scalar();
	}
}

