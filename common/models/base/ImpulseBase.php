<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "impulse".
 *
 * @property int $id id
 * @property int $admin_id 用户id
 * @property string $date 日期
 * @property string $amount 金额
 * @property int $type 类型(1-抑制；2-冲动)
 * @property string $remark 备注
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 */
class ImpulseBase extends \common\extensions\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'impulse';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['admin_id'], 'integer'],
            [['date'], 'required'],
            [['date', 'create_time', 'update_time'], 'safe'],
            [['amount'], 'number'],
            [['type'], 'string', 'max' => 1],
            [['remark'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'admin_id' => '用户id',
            'date' => '日期',
            'amount' => '金额',
            'type' => '类型(1-抑制；2-冲动)',
            'remark' => '备注',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
