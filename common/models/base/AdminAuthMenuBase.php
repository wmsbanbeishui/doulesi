<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "admin_auth_menu".
 *
 * @property int $id ID
 * @property int $menu_id 菜单id
 * @property string $auth_name 权限名
 */
class AdminAuthMenuBase extends \common\extensions\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_auth_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_id'], 'integer'],
            [['auth_name'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'menu_id' => 'Menu ID',
            'auth_name' => 'Auth Name',
        ];
    }
}
