<?php

namespace common\extensions;

use common\helpers\Helper;
use common\models\table\AdminLog;
use common\models\table\AdminAuthMenu;
use Yii;
use yii\db\ActiveRecord as YiiActiveRecord;

/**
 * @method ActiveQuery hasMany($class, array $link) see [[BaseActiveRecord::hasMany()]] for more info
 * @method ActiveQuery hasOne($class, array $link) see [[BaseActiveRecord::hasOne()]] for more info
 */
class ActiveRecord extends YiiActiveRecord {
	/**
	 * @return ActiveQuery
	 * @throws \yii\base\InvalidConfigException
	 */
	public static function find() {
		return Yii::createObject(ActiveQuery::className(), [get_called_class()]);
	}

	/**
	 * 清空表
	 * @return int
	 * @throws \yii\db\Exception
	 */
	public static function truncateTable() {
		return static::getDb()
			->createCommand()
			->truncateTable(static::tableName())
			->execute();
	}

	/**
	 * 获取第一条错误
	 * @return string
	 */
	public function getFirstErrorString() {
		if ($this->hasErrors()) {
			return current($this->getFirstErrors());
		}
		return '';
	}

	/**
	 * 记录管理后台用户操作日志
	 * @author luotaipeng
	 */
	public function afterSave($insert, $changedAttributes) {
		$table = $this->tableName();

		// 记录管理后台修改记录
		$track_list = ['admin'];
		$ignore_tables = ['admin_log'];
		if (in_array(Yii::$app->id, $track_list) && !in_array($table, $ignore_tables)) {
			$admin_id = Yii::$app->user->id;
			$route = '/'.Yii::$app->controller->route;
			$menu = AdminAuthMenu::findOne(['auth_name' => $route]);
			$menu_id = $menu ? $menu->menu_id : 0;
			$data = $this->getAttributes();
			if ($insert) {
				$admin_log = new AdminLog();
				$admin_log->admin_id = $admin_id;
				$admin_log->menu_id = $menu_id;
				$admin_log->table = $table;
				$admin_log->action = 1;
				$admin_log->record_id = isset($this->id) ? $this->id : null;
				$admin_log->new = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
				$success = $admin_log->save();
				if (!$success) {
					$error = $admin_log->getErrors();
					Helper::fLogs([$error, $_SERVER], 'admin_log_save_error.log');
				}
			} else {
				foreach ($changedAttributes as $key => $value) {
					if (array_key_exists($key, $data) && $value != $data[$key]) {
						$admin_log = new AdminLog();
						$admin_log->admin_id = $admin_id;
						$admin_log->menu_id = $menu_id;
						$admin_log->table = $table;
						$admin_log->action = 2;
						$admin_log->field = $key;
						$admin_log->record_id = isset($this->id) ? $this->id : null;
						$admin_log->origin = strval($value);
						$admin_log->new = strval($data[$key]);
						$success = $admin_log->save();
						if (!$success) {
							$error = $admin_log->getErrors();
							Helper::fLogs([$error, $_SERVER], 'admin_log_save_error.log');
						}
					}
				}
			}
		}

		// 记录经销商会员修改记录
		$track_list = ['mch'];
		$ignore_tables = ['mch_log'];
		if (in_array(Yii::$app->id, $track_list) && !in_array($table, $ignore_tables)) {
			$user_id = intval(Yii::$app->user->id);
			$route = '/'.Yii::$app->controller->route;
			$data = $this->getAttributes();
			if ($insert) {
				$mch_log = new MchLog();
				$mch_log->user_id = $user_id;
				$mch_log->table = $table;
				$mch_log->action = 1;
				$mch_log->record_id = isset($this->id) ? $this->id : null;
				$mch_log->new = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
				$success = $mch_log->save();
				if (!$success) {
					$error = $mch_log->getErrors();
					Helper::fLogs([$error, $_SERVER], 'mch_log_save_error.log');
				}
			} else {
				foreach ($changedAttributes as $key => $value) {
					if (array_key_exists($key, $data) && $value != $data[$key]) {
						$mch_log = new MchLog();
						$mch_log->user_id = $user_id;
						$mch_log->table = $table;
						$mch_log->action = 2;
						$mch_log->field = $key;
						$mch_log->record_id = isset($this->id) ? $this->id : null;
						$mch_log->origin = strval($value);
						$mch_log->new = strval($data[$key]);
						$success = $mch_log->save();
						if (!$success) {
							$error = $mch_log->getErrors();
							Helper::fLogs([$error, $_SERVER], 'mch_log_save_error.log');
						}
					}
				}
			}
		}

		// 记录移动版中经销商会员操作记录
		$track_list = ['m'];
		$ignore_tables = ['mch_log'];
		if (
			in_array(Yii::$app->id, $track_list) &&
			!in_array($table, $ignore_tables) &&
			(strpos(Yii::$app->controller->route, 'mch/') === 0) &&
			(strpos($table, 'mch_') === 0)
		) {
			$user_id = intval(Yii::$app->mch_user->id);
			$route = '/'.Yii::$app->controller->route;
			$data = $this->getAttributes();
			if ($insert) {
				$mch_log = new MchLog();
				$mch_log->user_id = $user_id;
				$mch_log->table = $table;
				$mch_log->action = 1;
				$mch_log->record_id = isset($this->id) ? $this->id : null;
				$mch_log->new = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
				$success = $mch_log->save();
				if (!$success) {
					$error = $mch_log->getErrors();
					Helper::fLogs([$error, $_SERVER], 'mch_log_save_error.log');
				}
			} else {
				foreach ($changedAttributes as $key => $value) {
					if (array_key_exists($key, $data) && $value != $data[$key]) {
						$mch_log = new MchLog();
						$mch_log->user_id = $user_id;
						$mch_log->table = $table;
						$mch_log->action = 2;
						$mch_log->field = $key;
						$mch_log->record_id = isset($this->id) ? $this->id : null;
						$mch_log->origin = strval($value);
						$mch_log->new = strval($data[$key]);
						$success = $mch_log->save();
						if (!$success) {
							$error = $mch_log->getErrors();
							Helper::fLogs([$error, $_SERVER], 'mch_log_save_error.log');
						}
					}
				}
			}
		}

		return parent::afterSave($insert, $changedAttributes);
	}

	/**
	 * 记录删除操作日志
	 * @author luotaipeng
	 */
	public function afterDelete() {
		$table = $this->tableName();

		// 记录管理后台修改记录
		$track_list = ['admin'];
		$ignore_tables = ['admin_log'];
		if (in_array(Yii::$app->id, $track_list) && !in_array($table, $ignore_tables)) {
			$admin_id = Yii::$app->user->id;
			$route = '/'.Yii::$app->controller->route;
			$menu = AdminAuthMenu::findOne(['auth_name' => $route]);
			$menu_id = $menu ? $menu->menu_id : 0;
			$data = $this->getAttributes();
			$admin_log = new AdminLog();
			$admin_log->admin_id = $admin_id;
			$admin_log->menu_id = $menu_id;
			$admin_log->table = $table;
			$admin_log->action = 3;
			$admin_log->record_id = isset($this->id) ? $this->id : null;
			$admin_log->new = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
			$success = $admin_log->save();
			if (!$success) {
				$error = $admin_log->getErrors();
				Helper::fLogs([$error, $_SERVER], 'admin_log_save_error.log');
			}
		}

		// 记录经销商会员修改记录
		$track_list = ['mch'];
		$ignore_tables = ['mch_log'];
		if (in_array(Yii::$app->id, $track_list) && !in_array($table, $ignore_tables)) {
			$user_id = intval(Yii::$app->user->id);
			$route = '/'.Yii::$app->controller->route;
			$data = $this->getAttributes();
			$mch_log = new MchLog();
			$mch_log->user_id = $user_id;
			$mch_log->table = $table;
			$mch_log->action = 3;
			$mch_log->record_id = isset($this->id) ? $this->id : null;
			$mch_log->new = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
			$success = $mch_log->save();
			if (!$success) {
				$error = $mch_log->getErrors();
				Helper::fLogs([$error, $_SERVER], 'mch_log_save_error.log');
			}
		}

		return true;
	}
}
