<?php

namespace common\extensions;

use yii\db\ActiveQuery as YiiActiveQuery;

/**
 * @see ActiveRecord
 */
class ActiveQuery extends YiiActiveQuery
{
	use QueryTrait;

	public function one($db = null)
	{
		$this->limit(1);
		return parent::one($db);
	}
}
