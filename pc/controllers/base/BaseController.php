<?php

namespace pc\controllers\base;

use Yii;
use yii\web\Controller;

class BaseController extends Controller
{
	public function init()
	{
		parent::init();

		$user = Yii::$app->getUser();
	}
}
