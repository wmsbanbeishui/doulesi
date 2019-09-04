<?php

namespace common\models\table;

use common\models\base\RecordBase;

class Record extends RecordBase
{
	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), [
			'admin_id' => '用户',
			'date' => '日期',
		]);
	}
}
