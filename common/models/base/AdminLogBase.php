<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "admin_log".
 *
 * @property int $id 自增ID
 * @property int $admin_id 后台用户ID
 * @property int $menu_id 菜单ID
 * @property int $action 操作：1-添加；2-修改；3-删除；4-登陆；5-登出；
 * @property string $content 详细操作说明
 * @property string $table 操作表
 * @property int $record_id 记录ID
 * @property string $field 修改字段
 * @property string $origin 原始内容
 * @property string $new 修改后内容
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 */
class AdminLogBase extends \common\extensions\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['admin_id', 'menu_id', 'action', 'record_id'], 'integer'],
            [['origin', 'new'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['content'], 'string', 'max' => 255],
            [['table', 'field'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'admin_id' => 'Admin ID',
            'menu_id' => 'Menu ID',
            'action' => 'Action',
            'content' => 'Content',
            'table' => 'Table',
            'record_id' => 'Record ID',
            'field' => 'Field',
            'origin' => 'Origin',
            'new' => 'New',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
