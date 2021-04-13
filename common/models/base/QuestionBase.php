<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "question".
 *
 * @property int $id id
 * @property string $content 问题内容
 * @property int $type 类型(1-单选；2-多选)
 * @property int $status 状态(0-停用；1-启用)
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 */
class QuestionBase extends \common\extensions\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_time', 'update_time'], 'safe'],
            [['content'], 'string', 'max' => 255],
            [['type', 'status'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'content' => '问题内容',
            'type' => '类型(1-单选；2-多选)',
            'status' => '状态(0-停用；1-启用)',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
