<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "currency".
 *
 * @property int $id ID
 * @property string $name 名称
 * @property int $order_index 排序，值越大越靠前
 * @property int $status 状态 1 正常 2 禁用
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 */
class CurrencyBase extends \common\extensions\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['order_index', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name'], 'string', 'max' => 30],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'order_index' => '排序，值越大越靠前',
            'status' => '状态 1 正常 2 禁用',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
