<?php

namespace common\extensions;

use yii\db\Query as YiiQuery;

class Query extends YiiQuery
{
	use QueryTrait;

	public function one($db = null)
	{
		$this->limit(1);
		return parent::one($db);
	}
}
