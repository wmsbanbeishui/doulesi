<?php

namespace common\models\table;

use common\models\base\ChowmatisticBase;
use yii\helpers\ArrayHelper;

class Chowmatistic extends ChowmatisticBase
{
	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), [
			'cur_id' => '币种',
			'cat_id' => '类别',
			//'status' => '状态',
			//'order_index' => '排序'
		]);
	}

	const CAT_EMPTY = 1;
	const STATUS_MANY = 2;
	public static function catMap($value = null)
	{
		$map = [
			self::CAT_EMPTY => '开空',
			self::STATUS_MANY => '开多',
		];
		if ($value === null) {
			return $map;
		}
		return ArrayHelper::getValue($map, $value, $value);
	}
}
