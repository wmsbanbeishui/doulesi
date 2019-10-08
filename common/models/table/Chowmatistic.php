<?php

namespace common\models\table;

use common\models\base\ChowmatisticBase;
use yii\helpers\ArrayHelper;

class Chowmatistic extends ChowmatisticBase
{
	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), [
			'cur_id' => '币种',
			'cat_id' => '类别',
			'rmb' => '价格（RMB）',
			'offset_time' => '时间',
			//'order_index' => '排序'
		]);
	}
}
