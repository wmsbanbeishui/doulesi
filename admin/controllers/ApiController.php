<?php
namespace admin\controllers;

use admin\controllers\base\AuthController;
use common\models\table\Category;
use Yii;

class ApiController extends AuthController
{
	public function actionLevel()
	{
		Yii::$app->response->format = 'json';
		$level_id = Yii::$app->request->post('level_id');
		if ($level_id == null) {
			return ['code' => 0, 'data' => []];
		}
		$data = Category::find()
			->select(['id', 'name'])
			->where(['level' => $level_id])
			->all();
		return ['code' => 0, 'data' => $data];
	}
}
