<?php
namespace common\services;

use common\models\table\Category;
use yii\helpers\ArrayHelper;

class CategoryService
{
	public static function getNameById($id)
	{
		return Category::find()->select(['name'])->where(['id' => $id])->scalar();
	}

	/**
	 * 根据level获取category
	 * @param $level_id
	 */
	public static function getCatByLevel($level_id)
	{
		$data = Category::find()->select(['id', 'name'])->where(['level' => $level_id, 'status' => 1])->all();
		return ArrayHelper::map($data, 'id', 'name');
	}
}
