<?php

namespace common\models\table;

use common\models\base\LevelBase;
use yii\helpers\ArrayHelper;

class Level extends LevelBase
{
	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), [
			'status' => '状态',
			'order_index' => '排序'
		]);
	}

	public static function map()
	{
		$query = self::find()->select(['id', 'name'])->where(['status' => 1])->orderBy(['order_index' => SORT_DESC]);

		$data = $query->all();
		$map = ArrayHelper::map($data, 'id', 'name');
		return $map;
	}

	const STATUS_ENABLE = 1;
	const STATUS_DISABLE = 2;
	public static function statusMap($value = null)
	{
		$map = [
			self::STATUS_ENABLE => '启用',
			self::STATUS_DISABLE => '停用',
		];
		if ($value === null) {
			return $map;
		}
		return ArrayHelper::getValue($map, $value, $value);
	}

}
