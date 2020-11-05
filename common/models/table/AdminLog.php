<?php

namespace common\models\table;

use common\models\base\AdminLogBase;
use yii\helpers\ArrayHelper;

class AdminLog extends AdminLogBase
{
	public static function actionMap($key = null) {
		$map = ['1' => '添加', '2' => '修改', '3' => '删除', '4' => '登陆', '5' => '登出'];
		if ($key === null) {
			return $map;
		}
		return ArrayHelper::getValue($map, $key, $key);
	}
}
