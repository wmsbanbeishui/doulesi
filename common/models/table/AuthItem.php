<?php

namespace common\models\table;

use common\models\base\AuthRuleBase;
use common\models\base\AuthItemBase;

class AuthItem extends AuthItemBase
{
	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return array_merge(parent::rules(), [
			[['rule_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthRuleBase::className(), 'targetAttribute' => ['rule_name' => 'name']],
		]);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getAuthAssignments()
	{
		return $this->hasMany(AuthAssignment::className(), ['item_name' => 'name']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getRuleName()
	{
		return $this->hasOne(AuthRuleBase::className(), ['name' => 'rule_name']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getAuthItemChildren()
	{
		return $this->hasMany(AuthItemChild::className(), ['parent' => 'name']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getAuthItemChildren0()
	{
		return $this->hasMany(AuthItemChild::className(), ['child' => 'name']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getChildren()
	{
		return $this->hasMany(AuthItem::className(), ['name' => 'child'])->viaTable('auth_item_child', ['parent' => 'name']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getParents()
	{
		return $this->hasMany(AuthItem::className(), ['name' => 'parent'])->viaTable('auth_item_child', ['child' => 'name']);
	}
}
