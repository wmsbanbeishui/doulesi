<?php

namespace admin\models\form;

use Yii;
use yii\base\Model;
use common\models\table\Admin;

class PasswordForm extends Model
{
	public $old_password;
	public $new_password;
	public $rep_passwor;

	private $_user = null;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['old_password', 'new_password', 'rep_passwor'], 'required'],
			['rep_passwor', 'compare', 'compareAttribute' => 'new_password'],
			['new_password', function ($attribute, $params, $validator) {
				if ($this->old_password == $this->new_password) {
					$this->addError($attribute, '新旧密码不能相同');
				}
			}],
			['old_password', function ($attribute, $params, $validator) {
				/** @var \backend\models\User $user */
				$user = $this->getUser();
				if (!$user->validatePassword($this->old_password)) {
					$this->addError($attribute, '旧密码错误');
				}
			}],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'old_password' => '旧密码',
			'new_password' => '新密码',
			'rep_passwor' => '确认密码',
		];
	}

	public function modifyPassword()
	{
		if (!$this->validate()) {
			return false;
		}
		$user = $this->getUser();
		$user->password = $user->encryptPassword($this->new_password);
		// 修改密码时将过期时间设为空
		$user->pwd_expired = null;
		return $user->save();
	}

	/**
	 * @return \backend\models\User
	 */
	public function getUser()
	{
		if ($this->_user == null) {
			$this->_user = Admin::findOne([
				'id' => Yii::$app->user->id,
				'status' => Admin::STATUS_ENABLE,
			]);
		}
		return $this->_user;
	}
}
