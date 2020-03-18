<?php

namespace common\models\table;

use common\models\base\SalaryBase;
use yii\helpers\ArrayHelper;

class Salary extends SalaryBase
{

	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(),[
			'admin_id' => '用户',
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
