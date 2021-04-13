<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "answer".
 *
 * @property int $id id
 * @property int $user_id 用户id
 * @property int $question_id 问题id
 * @property int $option_id 选项id
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 */
class AnswerBase extends \common\extensions\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'answer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'question_id', 'option_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'user_id' => '用户id',
            'question_id' => '问题id',
            'option_id' => '选项id',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
