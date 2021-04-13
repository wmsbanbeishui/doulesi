<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "option".
 *
 * @property int $id id
 * @property int $question_id 问题id
 * @property string $content 选项内容
 * @property int $status 状态(0-停用；1-启用)
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 */
class OptionBase extends \common\extensions\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'option';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['content'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'question_id' => '问题id',
            'content' => '选项内容',
            'status' => '状态(0-停用；1-启用)',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
