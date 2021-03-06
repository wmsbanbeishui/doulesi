<?php

namespace admin\controllers;

use admin\controllers\base\BaseController;
use admin\models\form\LoginForm;
use common\helpers\Helper;
use common\helpers\Message;
use common\models\table\AdminLog;
use Yii;
use yii\filters\AccessControl;

class UserController extends BaseController
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'actions' => [
							'login',
						],
						'roles' => ['?'],
					],
					[
						'allow' => true,
						'actions' => [
							'logout',
						],
						'roles' => ['@'],
					],
				],
				'denyCallback' => function ($rule, $action) {
					return $this->goBack();
				},
			],
		];
	}

	public function actionLogin()
	{
		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}

		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post())) {
			if ($model->login()) {
				// 记录登陆日志
				$admin_log = new AdminLog();
				$admin_log->admin_id = Yii::$app->user->id;
				$admin_log->table = 'admin';
				$admin_log->action = 4;
				$success = $admin_log->save();
				if (!$success) {
					$error = $admin_log->getErrors();
					Helper::fLogs([$error, $_SERVER], 'admin_log_save_error.log');
				}
				return $this->redirect(['/']);
			} else {
				Message::setErrorMsg('登录失败');
			}
		}

		return $this->render('login', [
			'model' => $model,
		]);

	}

	public function actionLogout()
	{
		// 记录登出日志
		$admin_log = new AdminLog();
		$admin_log->admin_id = Yii::$app->user->id;
		$admin_log->table = 'admin';
		$admin_log->action = 5;
		$success = $admin_log->save();
		if (!$success) {
			$error = $admin_log->getErrors();
			Helper::fLogs([$error, $_SERVER], 'admin_log_save_error.log');
		}

		Yii::$app->user->logout();
		Message::setMessage('已登出');
		return $this->redirect(['login']);
	}
}
