<?php

namespace common\models\table;

use common\models\base\ImpulseBase;
use yii\helpers\ArrayHelper;

class Impulse extends ImpulseBase
{

	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(),[
			'admin_id' => '用户',
			'type' => '类型',
		]);
	}

	const TYPE_RESTRAIN = 1;
	const TYPE_IMPULSE = 2;
	public static function typeMap($value = null)
	{
		$map = [
			self::TYPE_RESTRAIN => '抑制',
			self::TYPE_IMPULSE => '冲动',
		];
		if ($value === null) {
			return $map;
		}
		return ArrayHelper::getValue($map, $value, $value);
	}
}
