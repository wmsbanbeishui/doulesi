<?php

namespace common\models\table;

use common\models\base\AccountBase;
use yii\helpers\ArrayHelper;

class Account extends AccountBase
{
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'order_index' => '排序'
        ]);
    }

    public static function map()
    {
        $query = self::find()->select(['id', 'title'])->orderBy(['order_index' => SORT_DESC]);

        $data = $query->all();
        $map = ArrayHelper::map($data, 'id', 'title');
        return $map;
    }
}
