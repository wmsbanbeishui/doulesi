<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "salary".
 *
 * @property int $id ID
 * @property int $admin_id 用户ID
 * @property string $salary 工资
 * @property string $date 日期
 * @property string $remark 备注
 * @property int $status 状态
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 */
class SalaryBase extends \common\extensions\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'salary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['admin_id', 'date'], 'required'],
            [['admin_id', 'status'], 'integer'],
            [['salary'], 'number'],
            [['date', 'create_time', 'update_time'], 'safe'],
            [['remark'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'admin_id' => '用户ID',
            'salary' => '工资',
            'date' => '日期',
            'remark' => '备注',
            'status' => '状态',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
