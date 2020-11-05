<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "double_eleven".
 *
 * @property int $id id
 * @property string $product 名称
 * @property string $price 价格
 * @property string $year 年
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 */
class DoubleElevenBase extends \common\extensions\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'double_eleven';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price'], 'number'],
            [['year'], 'required'],
            [['year', 'create_time', 'update_time'], 'safe'],
            [['product'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'product' => '名称',
            'price' => '价格',
            'year' => '年',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
