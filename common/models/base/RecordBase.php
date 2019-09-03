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
            [['id', 'admin_id', 'record', 'date'], 'required'],
            [['id', 'admin_id'], 'integer'],
            [['date', 'create_time', 'update_time'], 'safe'],
            [['record'], 'string', 'max' => 255],
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
            'record' => 'Record',
            'date' => 'Date',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
