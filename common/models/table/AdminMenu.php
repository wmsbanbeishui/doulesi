<?php

namespace common\models\table;

use common\models\base\AdminMenuBase;
use yii\helpers\ArrayHelper;

class AdminMenu extends AdminMenuBase {
	const STATUS_ENABLE = 1;
	const STATUS_DISABLE = 0;

	/**
	 * @param int|string $value
	 * @return array|string
	 */
	public static function statusMap($value = null) {
		$map = [
			self::STATUS_ENABLE => '启用',
			self::STATUS_DISABLE => '禁用',
		];
		if ($value === null) {
			return $map;
		}
		return ArrayHelper::getValue($map, $value, $value);
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return array_merge(parent::rules(), [
			['status', 'in', 'range' => [self::STATUS_ENABLE, self::STATUS_DISABLE]],
		]);
	}
}
