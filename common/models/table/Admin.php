<?php

namespace common\models\table;

use common\models\base\AdminBase;
use common\validator\MobileValidator;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

class Admin extends AdminBase implements IdentityInterface {
	const STATUS_ENABLE = 1;
	const STATUS_DISABLE = 0;

	/**
	 * @param int|string $value
	 * @return array|string
	 */
	public static function statusMap($value = null) {
		$map = [
			self::STATUS_ENABLE => '已启用',
			self::STATUS_DISABLE => '未启用',
		];
		if ($value === null) {
			return $map;
		}
		return ArrayHelper::getValue($map, $value, $value);
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return array_merge(parent::rules(), [
			['mobile', MobileValidator::className()],
			['email', 'email'],
			['status', 'in', 'range' => [self::STATUS_ENABLE, self::STATUS_DISABLE]],
		]);
	}

	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), [
			'status' => '状态',
		]);
	}

	/**
	 * @inheritdoc
	 */
	public static function findIdentity($id) {
		return self::findOne(['id' => $id]);
	}

	/**
	 * @inheritdoc
	 */
	public static function findIdentityByAccessToken($token, $type = null) {
		return null;
	}

	/**
	 * @inheritdoc
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @inheritdoc
	 */
	public function getAuthKey() {
		return null;
	}

	public function validateAuthKey($authKey) {
		return $this->getAuthKey() == $authKey;
	}

	/**
	 * 验证密码
	 *
	 * @param $password
	 * @return bool
	 */
	public function validatePassword($password) {
		return Yii::$app->getSecurity()->validatePassword($password, $this->password);
	}

	/**
	 * 加密密码
	 *
	 * @param $password
	 * @return string
	 * @throws \yii\base\Exception
	 */
	public function encryptPassword($password) {
		return Yii::$app->getSecurity()->generatePasswordHash($password);
	}

	/**
	 * 设置密码
	 *
	 * @param $password
	 * @throws \yii\base\Exception
	 */
	public function setPassword($password) {
		$this->password = $this->encryptPassword($password);
	}
}
