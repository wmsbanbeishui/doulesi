<?php
namespace admin\models\form;

use common\models\table\Admin;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
	//public $verifyCode;

    private $_user = false;

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'username' => '用户名',
			'password' => '密码',
			//'verifyCode' => '验证码',
		];
	}


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
			['username', 'string', 'max' => 40],
            ['password', 'validatePassword'],
			//[['verifyCode'], 'captcha', 'captchaAction' => '/site/captcha'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError('username', '用户名或密码错误');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
			$user = $this->getUser();
			return Yii::$app->user->login($user, 86400);
        }

        return false;
    }

    protected function getUser()
    {
        if ($this->_user === false) {
			$email = '';
			$mobile = '';
			$username = '';

			if (is_numeric($this->username)) {
				$mobile = $this->username;
			} elseif (strstr($this->username, '@')) {
				$email = $this->username;
			} else {
				$username = $this->username;
			}

			$this->_user = Admin::find()
				->where(['status' => Admin::STATUS_ENABLE])
				->andFilterWhere([
					'email' => $email,
					'mobile' => $mobile,
					'username' => $username
				])
				->one();
        }

        return $this->_user;
    }
}
