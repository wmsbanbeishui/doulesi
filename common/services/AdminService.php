<?php
namespace common\services;

use common\models\table\Admin;

class AdminService
{
	public static function getNameById ($id) {
		return Admin::find()->select(['realname'])->where(['id' => $id])->scalar();
	}
}
