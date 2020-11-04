<?php

namespace admin\controllers;

use admin\controllers\base\AuthController;
use admin\models\search\AdminLogSearch;
use common\models\table\AdminLog;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * AdminLogController implements the CRUD actions for AdminLog model.
 */
class AdminLogController extends AuthController {
    /**
     * Lists all AdminLog models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AdminLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id) {
        if (($model = AdminLog::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
