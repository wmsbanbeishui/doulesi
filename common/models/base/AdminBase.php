<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "admin".
 *
 * @property int $id ID
 * @property string $username
 * @property string $realname
 * @property string $password 密码
 * @property int $mobile 手机号码
 * @property string $avatar 用户头像
 * @property int $status 状态：1 正常 2 禁用
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 */
class AdminBase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin';
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
            [['username', 'realname', 'password', 'avatar'], 'string', 'max' => 255],
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
            'avatar' => 'Avatar',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
