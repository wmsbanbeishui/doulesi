<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "admin_menu".
 *
 * @property int $id 菜单ID
 * @property int $pid 父菜单ID
 * @property string $name 菜单名称
 * @property string $uri 路由地址
 * @property string $icon 图标
 * @property int $order_index 排序值：越大越靠前
 * @property int $status 状态：0-停用；1-启用；
 * @property string $description 功能说明
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 */
class AdminMenuBase extends \common\extensions\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin_menu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pid', 'order_index', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name', 'icon'], 'string', 'max' => 45],
            [['uri', 'description'], 'string', 'max' => 255],
            [['uri'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '菜单ID',
            'pid' => '父菜单ID',
            'name' => '菜单名称',
            'uri' => '路由地址',
            'icon' => '图标',
            'order_index' => '排序值：越大越靠前',
            'status' => '状态：0-停用；1-启用；',
            'description' => '功能说明',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
