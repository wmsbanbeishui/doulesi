<?php

namespace admin\controllers;

use admin\controllers\base\AuthController;
use admin\models\Admin;
use admin\models\Auth;
use admin\models\form\PasswordForm;
use common\helpers\FileHelper;
use common\helpers\Message;
use common\models\base\AuthAssignment;
use common\models\base\AuthItem;
use common\models\table\AuthItemChild;
use common\models\base\AuthItemAuthItemChild;
use common\services\AdminLogService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * AdminController implements the CRUD actions for Admin model.
 */
class AdminController extends AuthController
{
	/**
	 * {@inheritdoc}
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
	 * Lists all Admin models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new Admin();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Admin model.
	 * @param  int $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new Admin model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Admin();
		if ($model->load(Yii::$app->request->post())) {
			if (empty($model->password)) {
				Message::setErrorMsg('密码不能为空');
				return $this->render('create', [
					'model' => $model,
				]);
			}

			if (!empty($model->password)) {
				$model->setPassword($model->password);
			}

			if ($model->username == '') {
				$model->username = null;
			}

			if ($model->save()) {
				Message::setSuccessMsg('添加成功');
				return $this->redirect(['index']);
			} else {
				Message::setErrorMsg('添加失败');
			}
		}

		return $this->render('create', [
			'model' => $model,
		]);
	}

	/**
	 * Updates an existing Admin model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param  int $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id)
	{
		if ($id == 1 && Yii::$app->user->id > 1) {
			Message::setErrorMsg('你没有修改超级管理员的权限。');
			return $this->redirect(['index']);
		}

		$request = Yii::$app->request;
		$model = $this->findModel($id);

		if ($request->isPost) {
			$post = $request->post($model->formName(), []);

			if (empty($post['username'])) {
				$post['username'] = null;
			}

			if (empty($post['password'])) {
				unset($post['password']);
			}
			$model->setAttributes($post);
			// T-1053 超级管理员不可禁用
			if ($id == 1) {
				$model->status = 1;
			}
			if (isset($post['password'])) {
				$model->setPassword($post['password']);
			}
			if ($model->save()) {
				Message::setSuccessMsg('修改成功');
				return $this->redirect(['index']);
			} else {
				Message::setErrorMsg('修改失败');
			}
		}

		return $this->render('update', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes an existing Admin model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param  int $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id)
	{
		if ($id == 1) {
			Message::setErrorMsg('超级管理员不可删除。');
			return $this->redirect(['index']);
		}
		$this->findModel($id)->delete();
		return $this->redirect(['index']);
	}

	/**
	 * Finds the Admin model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param  int $id
	 * @return Admin                 the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Admin::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}

	public function actionSetRoles($id)
	{
		$all_role = AuthItem::find(['name', 'description'])->where(['type' => 1])->all();
		$my_role = AuthAssignment::find(['name'])->where(['user_id' => $id])->column();

		return $this->render('set_roles', [
			'id' => $id,
			'all_role' => $all_role,
			'my_role' => $my_role,
		]);
	}

	public function actionSetted()
	{
		$auth = Yii::$app->authManager;
		$post = Yii::$app->request->post();

		$request = Yii::$app->request;
		$user_id = $request->post('user_id');
		$roles = $request->post('roles', []);

		// 获取用户原有角色
		$old_roles = array_keys($auth->getRolesByUser($user_id));
		// 将新增的角色
		$add_roles = array_values(array_diff($roles, $old_roles));
		// 将删除的角色
		$del_roles = array_values(array_diff($old_roles, $roles));
		// 有修改的角色
		$diff_roles = array_merge($del_roles, $add_roles);

		if (Yii::$app->user->id != 1) {
			// 查询敏感角色
			$check_roles = AuthItemChild::find()
				->andWhere(['like', 'child', '#/admin/%', false])
				->select('parent')
				->column();
			// T-1053 敏感角色只允许超级管理员操作
			if (array_intersect($diff_roles, $check_roles)) {
				Message::setErrorMsg('敏感角色有变化请联系超级管理员操作');
				return $this->redirect(['index']);
			}
		}

		// T-1061 记录用户角色添加日志
		if ($add_roles) {
			$data = [
				'action' => 1,
				'table' => 'admin',
				'record_id' => $user_id,
				'field' => 'role',
				'new' => json_encode($add_roles, JSON_UNESCAPED_SLASHES),
			];
			AdminLogService::save($data);
		}

		// T-1061 记录用户角色删除日志
		if ($del_roles) {
			$data = [
				'action' => 3,
				'table' => 'admin',
				'record_id' => $user_id,
				'field' => 'role',
				'new' => json_encode($del_roles, JSON_UNESCAPED_SLASHES),
			];
			AdminLogService::save($data);
		}

		$auth->revokeAll($user_id);
		foreach ($roles as $name) {
			$role = $auth->createRole($name);
			$auth->assign($role, $user_id);
		}

		return $this->redirect(['index']);
	}

	public function actionMine()
	{
		$model = Admin::findOne(Yii::$app->user->id);
		$post_data = Yii::$app->request->post();

		// 去除不允许修改的字段
		if ($post_data) {
			foreach ($post_data['Admin'] as $key => $item) {
				if ($key != 'username' && $key != 'email') {
					unset($post_data['Admin'][$key]);
				}
			}
		}

		if ($model->load($post_data)) {
			if ($_FILES['avatar']['name']) {
				$up = FileHelper::qnUpload($_FILES['avatar'], 'admin');
				if ($up['errno'] == 0) {
					$model->avatar = $up['key'];
				}
			}
			if (empty($model->username)) {
				$model->username = null;
			}
			if (empty($model->email)) {
				$model->email = null;
			}
			if ($model->save()) {
				Message::setSuccessMsg('修改成功');
				return $this->redirect(['mine']);
			} else {
				Message::setErrorMsg('修改失败');
			}
		}

		return $this->render('mine', [
			'model' => $model,
		]);
	}

	public function actionPassword()
	{
		$model = new PasswordForm();

		if ($model->load(Yii::$app->request->post())) {
			if ($model->modifyPassword()) {
				Message::setSuccessMsg('修改成功');
				return $this->redirect(['password']);
			} else {
				Message::setErrorMsg('修改失败');
			}
		}

		return $this->render('password', [
			'model' => $model,
		]);
	}

	public function actionGetUserAuth($id)
	{
		$roles = AuthAssignment::find()->select(['item_name'])->where(['user_id' => $id])->column();
		$child = AuthItemAuthItemChild::find()->select('child')->where(['parent' => $roles])->column();
		$list = array_unique($child);
		$items = [];
		foreach ($list as $item) {
			$items[$item] = $item;
		}

		$menu = Auth::getAuthTree($items);

		return $this->render('user_auth', [
			'menu' => array_values($menu),
		]);
	}
}
