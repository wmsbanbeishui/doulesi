<?php

namespace common\services;

use common\helpers\Helper;
use common\models\table\AdminLog;
use Yii;

/**
 * 管理后台日志 服务类
 * @author luotaipeng
 */
class AdminLogService
{
	/**
	 * 生成管理后台日志
	 * @param data array 日志内容
	 * @author luotaipeng
	 */
	public static function save($data = null)
	{
		$data = array_merge([
			'admin_id' => Yii::$app->user->id,
			'menu_id' => Helper::get_menu_id(),
			'action' => 1,
		], $data);
		$admin_log = new AdminLog();
		$admin_log->setAttributes($data);
		$success = $admin_log->save();
		if (!$success) {
			$error = $admin_log->getErrors();
			Helper::fLogs([$error, $_SERVER], 'admin_log_save_error.log');
		}

		return $success;
	}
}
