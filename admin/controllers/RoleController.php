<?php

namespace admin\controllers;

use admin\controllers\base\AuthController;
use common\services\AdminLogService;
use Yii;
use admin\models\Auth;
use admin\models\search\RoleSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RoleController implements the CRUD actions for Auth model.
 */
class RoleController extends AuthController
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
     * Lists all Auth models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RoleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Auth model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
		$model = Auth::find()
			->with([
				'authAdmin' => function ($query) {
					$query->select(['id', 'realname']);
				}
			])
			->where(['type' => 1, 'name' => $id])
			->one();
		return $this->render('view', [
			'model' => $model
		]);
    }

    /**
     * Creates a new Auth model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Auth();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Auth model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Auth model.
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
     * Finds the Auth model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Auth the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Auth::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

	public function actionList($role)
	{
		$items = Yii::$app->authManager->getPermissionsByRole($role);
		$menu = Auth::getAuthTree($items);

		return $this->render('list', ['menu' => array_values($menu), 'role' => $role]);
	}

	public function actionListDo()
	{
		Yii::$app->response->format = 'json';
		$auth = Yii::$app->authManager;
		$request = Yii::$app->request;
		$role_name = $request->post('role');
		$authData = $request->post('prem');
		if ($authData) {
			$authData = array_unique($authData);
		}

		// 查询修改前的角色权限项
		$old_auth_items = array_keys($auth->getPermissionsByRole($role_name));
		// 将新增的角色
		$add_items = array_values(array_diff($authData, $old_auth_items));
		// 将删除的角色
		$del_items = array_values(array_diff($old_auth_items, $authData));
		// 有修改的权限项
		$diff_items = array_merge($add_items, $del_items);

		if (Yii::$app->user->id != 1) {
			// T-1053 特定权限只允许超级管理员添加到角色中
			foreach ($diff_items as $auth_name) {
				if (substr($auth_name, 0, 8) == '#/admin/') {
					return ['errno' => 501, 'msg' => '敏感权限有变化请联系超级管理员操作'];
				}
			}
		}

		// T-1061 记录用户角色添加日志
		if ($add_items) {
			$data = [
				'action' => 1,
				'table' => 'auth_item',
				'record_id' => Yii::$app->user->id,
				'field' => 'auth_items',
				'origin' => $role_name,
				'new' => json_encode($add_items, JSON_UNESCAPED_SLASHES),
			];
			AdminLogService::save($data);
		}

		// T-1061 记录用户角色删除日志
		if ($del_items) {
			$data = [
				'action' => 3,
				'table' => 'auth_item',
				'record_id' => Yii::$app->user->id,
				'field' => 'auth_items',
				'origin' => $role_name,
				'new' => json_encode($del_items, JSON_UNESCAPED_SLASHES),
			];
			AdminLogService::save($data);
		}

		$transaction = Yii::$app->getDb()->beginTransaction();
		try {
			$role = $auth->createRole($role_name);
			$auth->removeChildren($role);

			if ($authData && is_array($authData)) {
				foreach ($authData as $item) {
					$child = $auth->createPermission($item);
					$auth->addChild($role, $child);
				}
			}
			$transaction->commit();
			return ['errno' => 0, 'msg' => '设置成功'];
		} catch (\Exception $exception) {
			$transaction->rollBack();
			return ['errno' => 1, 'msg' => '设置失败'];
		}
	}
}
