<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "record".
 *
 * @property int $id ID
 * @property int $admin_id 用户ID
 * @property string $record 记事
 * @property string $date 记事日期
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 */
class RecordBase extends \common\extensions\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['admin_id', 'record', 'date'], 'required'],
            [['admin_id'], 'integer'],
            [['date', 'create_time', 'update_time'], 'safe'],
            [['record'], 'string', 'max' => 255],
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
            'record' => '记事',
            'date' => '记事日期',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
