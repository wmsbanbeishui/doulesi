<?php

namespace common\models\table;

use common\models\base\SeoBase;
use yii\helpers\ArrayHelper;

class Seo extends SeoBase {
	const WEB_PC = 0;
	const WEB_M = 1;

	/**
	 * @param int|string $value
	 * @return array|string
	 */
	public static function webMap($value = null) {
		$map = [
			self::WEB_PC => 'PC端',
			self::WEB_M => '移动端',
		];
		if ($value === null) {
			return $map;
		}
		return ArrayHelper::getValue($map, $value, $value);
	}

	public static function enabledMap($key=null){
		$maps=['1'=>'启用','0'=>'禁用'];
		if($key===null){
			return $maps;
		}
		return ArrayHelper::getValue($maps,$key,'');
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return array_merge(parent::rules(), [
			['web', 'in', 'range' => [self::WEB_PC, self::WEB_M]],
		]);
	}
}
