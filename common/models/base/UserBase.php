<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id ID
 * @property string $username 用户名
 * @property string $realname 真实名
 * @property string $password 用户密码
 * @property int $mobile 手机号
 * @property string $email 用户邮箱
 * @property string $avatar 用户头像
 * @property int $status 状态：1 正常 2 禁用
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 */
class UserBase extends \common\extensions\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mobile'], 'required'],
            [['mobile'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['username', 'realname'], 'string', 'max' => 20],
            [['password', 'avatar'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 30],
            [['status'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'realname' => 'Realname',
            'password' => 'Password',
            'mobile' => 'Mobile',
            'email' => 'Email',
            'avatar' => 'Avatar',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
