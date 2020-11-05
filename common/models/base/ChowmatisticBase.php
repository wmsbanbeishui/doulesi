<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "chowmatistic".
 *
 * @property int $id ID
 * @property int $cur_id 币种ID
 * @property int $cat_id 类别 1 开多 2 开空
 * @property int $open_interest 成交量
 * @property string $final_price 成交价
 * @property string $profit 收益
 * @property string $profit2 收益乘以成交价
 * @property string $commission 手续费
 * @property string $commission2 手续费乘以成交价
 * @property string $remark 备注
 * @property string $offset_time 平仓时间
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 */
class ChowmatisticBase extends \common\extensions\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chowmatistic';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cur_id', 'cat_id', 'open_interest'], 'integer'],
            [['final_price', 'profit', 'profit2', 'commission', 'commission2'], 'number'],
            [['offset_time', 'create_time', 'update_time'], 'safe'],
            [['remark'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cur_id' => '币种ID',
            'cat_id' => '类别 1 开多 2 开空',
            'open_interest' => '成交量',
            'final_price' => '成交价',
            'profit' => '收益',
            'profit2' => '收益乘以成交价',
            'commission' => '手续费',
            'commission2' => '手续费乘以成交价',
            'remark' => '备注',
            'offset_time' => '平仓时间',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
