<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "work_log".
 *
 * @property int $id id
 * @property string $plan 工作计划
 * @property string $finish 工作内容
 * @property string $date 日期
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 */
class WorkLogBase extends \common\extensions\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'work_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['plan', 'finish'], 'string'],
            [['date', 'create_time', 'update_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'plan' => '工作计划',
            'finish' => '工作内容',
            'date' => '日期',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
