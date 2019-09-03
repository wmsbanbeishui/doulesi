<?php

namespace common\models\table;

use common\models\base\FinanceBase;
use yii\helpers\ArrayHelper;

class Finance extends FinanceBase
{

	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(),[
			'admin_id' => '用户',
			'level_id' => '等级',
			'cat_id' => '类别',
			'status' => '状态',
		]);
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
