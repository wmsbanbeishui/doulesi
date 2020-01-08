<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "account".
 *
 * @property int $id ID
 * @property string $title 标题
 * @property string $account 账号
 * @property string $password 密码
 * @property string $url 网址
 * @property int $admin_id 管理员
 * @property int $order_index 排序，越大越靠前
 * @property string $create_at 创建时间
 * @property string $update_at 更新时间
 */
class AccountBase extends \common\extensions\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['admin_id'], 'required'],
            [['admin_id', 'order_index'], 'integer'],
            [['create_at', 'update_at'], 'safe'],
            [['title', 'account', 'password', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'account' => '账号',
            'password' => '密码',
            'url' => '网址',
            'admin_id' => '管理员',
            'order_index' => '排序，越大越靠前',
            'create_at' => '创建时间',
            'update_at' => '更新时间',
        ];
    }
}
