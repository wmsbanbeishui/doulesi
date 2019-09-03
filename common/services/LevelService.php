<?php
namespace common\services;

use common\models\table\Level;

class LevelService
{
	public static function getNameById($id)
	{
		$name = Level::find()->select(['name'])->where(['id' => $id])->scalar();
		return $name;
	}
}
