<?php

namespace admin\controllers;

use admin\controllers\base\AuthController;
use admin\models\AdminMenu;
use admin\models\Auth;
use common\models\table\AdminAuthMenu;
use Yii;
use common\models\table\AuthItem;
use admin\models\search\AuthItemSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AuthItemController implements the CRUD actions for AuthItem model.
 */
class AuthItemController extends AuthController
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

    /**
     * Lists all AuthItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AuthItem model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
		$menu = AdminMenu::simpleMenu();
		$items = AdminAuthMenu::find()->select(['menu_id'])->where(['auth_name' => $id])->column();
		$menu = Auth::getAuthMenuTree($menu, $items);

		$model = Auth::find()
			->with(['parents'])
			->where(['type' => 2, 'name' => $id])
			->one();

		return $this->render('view', [
			'model' => $model,
			'menu' => array_values($menu)
		]);
    }

    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$menu = AdminMenu::simpleMenu();
		return $this->render('create', [
			'menu' => array_values($menu)
		]);
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
		$menu = AdminMenu::simpleMenu();
		$items = AdminAuthMenu::find()->select(['menu_id'])->where(['auth_name' => $id])->column();
		$menu = Auth::getAuthMenuTree($menu, $items);
		return $this->render('update', [
			'model' => $this->findModel($id),
			'menu' => array_values($menu)
		]);
    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthItem::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

	public function actionSaveAuth()
	{
		Yii::$app->response->format = 'json';
		$request = Yii::$app->request;
		$id = $request->post('id');
		$type = $request->post('type');
		$name = $request->post('name');
		$menu_ids = $request->post('menu_ids');
		$description = $request->post('description');

		// T-1053 敏感权限只允许超级管理员修改
		if (Yii::$app->user->id != 1) {
			if (substr($name, 0, 8) == '#/admin/' || substr($id, 0, 8) == '#/admin/') {
				return ['errno' => 501, 'msg' => '敏感权限请联系超级管理员修改'];
			}
		}

		if ($id) { //修改
			$model = $this->findModel($id);
			$model->type = $type;
			$model->name = $name;
			$model->description = $description;

			$transaction = Yii::$app->getDb()->beginTransaction();
			try {
				$model->save();
				AdminAuthMenu::deleteAll(['auth_name' => $id]);
				if (is_array($menu_ids)) {
					foreach ($menu_ids as $value) {
						$auth_menu = new AdminAuthMenu();
						$auth_menu->menu_id = $value;
						$auth_menu->auth_name = $name;
						$auth_menu->save();
					}
				}
				$transaction->commit();
				return ['errno' => 0, 'msg' => '修改成功'];
			} catch (\Exception $exception) {
				$transaction->rollBack();
				return ['errno' => 1, 'msg' => '修改失败'];
			}
		} else { //新增
			$model = new AuthItem();
			$model->type = $type;
			$model->name = $name;
			$model->description = $description;
			$transaction = Yii::$app->getDb()->beginTransaction();
			try {
				$model->save();
				if (is_array($menu_ids)) {
					foreach ($menu_ids as $value) {
						$auth_menu = new AdminAuthMenu();
						$auth_menu->menu_id = $value;
						$auth_menu->auth_name = $name;
						$auth_menu->save();
					}
				}
				$transaction->commit();
				return ['errno' => 0, 'msg' => '添加成功'];
			} catch (\Exception $exception) {
				$transaction->rollBack();
				return ['errno' => 1, 'msg' => '添加失败'];
			}
		}
	}
}
