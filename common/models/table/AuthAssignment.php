<?php

namespace common\models\table;

use common\models\base\AuthAssignmentBase;
use Yii;

/**
 * This is the model class for table "auth_assignment".
 *
 * @property string $item_name
 * @property string $user_id
 * @property int $created_at
 *
 * @property AuthItem $itemName
 */
class AuthAssignment extends AuthAssignmentBase
{
	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return array_merge(parent::rules(), [
			[['item_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => ['item_name' => 'name']],
		]);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getItemName()
	{
		return $this->hasOne(AuthItem::className(), ['name' => 'item_name']);
	}
}
