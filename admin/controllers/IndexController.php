<?php
namespace admin\controllers;

use Yii;
use admin\controllers\base\BaseController;

class IndexController extends BaseController {
	public function actionIndex() {
		return $this->render('index');
	}
}
