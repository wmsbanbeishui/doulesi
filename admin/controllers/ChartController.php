<?php

namespace admin\controllers;

use admin\models\search\ChartSearch;
use common\models\table\Finance;
use admin\controllers\base\AuthController;
use admin\models\search\FinanceSearch;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FinanceController implements the CRUD actions for Finance model.
 */
class ChartController extends AuthController
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
				],
			],
		];
	}

	public function actionIndex()
	{
		$searchModel = new ChartSearch();
		$data = $searchModel->search(Yii::$app->request->queryParams);

		$name = ArrayHelper::getColumn($data['info'], 'name');
		if ($data['type'] == 2) {
			$name = ArrayHelper::getColumn($data['info'], 'month');
		}

		$cost = ArrayHelper::getColumn($data['info'], 'cost_total');

		return $this->render('index', [
			'searchModel' => $searchModel,
			'name' => $name,
			'cost' => $cost,
			'sum_cost' => $data['sum_cost'],
			'type' => $data['type'],
		]);
	}
}
