<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "finance".
 *
 * @property int $id ID
 * @property int $admin_id 用户ID
 * @property int $level_id 等级ID
 * @property int $cat_id 类别ID
 * @property string $cost 金额
 * @property string $date 账单日期
 * @property string $remark 备注
 * @property int $status 状态 1 正常 2 禁用
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 */
class FinanceBase extends \common\extensions\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'finance';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'admin_id', 'date'], 'required'],
            [['id', 'admin_id', 'level_id', 'cat_id', 'status'], 'integer'],
            [['cost'], 'number'],
            [['date', 'create_time', 'update_time'], 'safe'],
            [['remark'], 'string', 'max' => 30],
            [['id'], 'unique'],
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
            'level_id' => 'Level ID',
            'cat_id' => 'Cat ID',
            'cost' => 'Cost',
            'date' => 'Date',
            'remark' => 'Remark',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
