<?php

namespace admin\models;

use common\models\table\AuthItem;
use common\models\table\AdminAuthMenu;
use common\models\table\AuthAssignment;

class Auth extends AuthItem
{
	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), [
			'name' => '名称',
			'description' => '描述',
		]);
	}

	/**
	 * 根据角色中的权限获取菜单权限树
	 * @param $items 角色中权限列表
	 */
	public static function getAuthTree($items)
	{
		$menus = AdminMenu::simpleMenu();

		$auth_items = [];
		$auth = AdminAuthMenu::find()
			->alias('am')
			->leftJoin(['ai' => AuthItem::tableName()], 'ai.name = am.auth_name')
			->where(['ai.type' => 2])
			->select(['am.menu_id', 'name' => 'am.auth_name', 'ai.description'])
			->asArray()
			->all();

		foreach ($auth as $item) {
			$menu_id = $item['menu_id'];
			if (!isset($auth_items[$menu_id])) {
				$auth_items[$menu_id] = [];
			}
			$auth_items[$menu_id][] = [
				'name' => $item['name'],
				'description' => $item['description'],
			];
		}

		$list = [];
		foreach ($menus as $key => $top_menu) {
			$list[$key]['name'] = $top_menu['name'];
			if (isset($auth_items[$top_menu['id']])) {
				foreach ($auth_items[$top_menu['id']] as $item) {
					$list[$key]['children'][] = [
						'name' => $item['name'],
						'description' => $item['description'],
						'checked' => isset($items[$item['name']]) ? true : false,
					];
				}
			}
			if (isset($top_menu['children'])) {
				$top_child_num = isset($list[$key]['children']) ? count($list[$key]['children']) : 0;
				foreach ($top_menu['children'] as $key2 => $side_menu) {
					$list[$key]['children'][$key2 + $top_child_num]['name'] = $side_menu['name'];
					if (isset($auth_items[$side_menu['id']])) {
						foreach ($auth_items[$side_menu['id']] as $item) {
							$list[$key]['children'][$key2 + $top_child_num]['children'][] = [
								'name' => $item['name'],
								'description' => $item['description'],
								'checked' => isset($items[$item['name']]) ? true : false,
							];
						}
					}
					if (isset($side_menu['children'])) {
						$side_child_num = isset($list[$key]['children'][$key2 + $top_child_num]['children']) ? count($list[$key]['children'][$key2 + $top_child_num]['children']) : 0;
						foreach ($side_menu['children'] as $key3 => $sub_menu) {
							$list[$key]['children'][$key2 + $top_child_num]['children'][$key3 + $side_child_num]['name'] = $sub_menu['name'];
							if (isset($auth_items[$sub_menu['id']])) {
								foreach ($auth_items[$sub_menu['id']] as $item) {
									$list[$key]['children'][$key2 + $top_child_num]['children'][$key3 + $side_child_num]['children'][] = [
										'name' => $item['name'],
										'description' => $item['description'],
										'checked' => isset($items[$item['name']]) ? true : false,
									];
								}
							}
						}
					}
				}
			}
		}
		return $list;
	}

	/**
	 * 根据菜单-权限关系获取菜单树
	 * @param $menu
	 * @param $items
	 */
	public static function getAuthMenuTree($menu, $items)
	{
		foreach ($menu as $key => $top_menu) {
			$menu[$key]['checked'] = false;
			if (in_array($top_menu['id'], $items)) {
				$menu[$key]['checked'] = true;
			}
			if (isset($top_menu['children'])) {
				foreach ($top_menu['children'] as $key2 => $side_menu) {
					$menu[$key]['children'][$key2]['checked'] = false;
					if (in_array($side_menu['id'], $items)) {
						$menu[$key]['children'][$key2]['checked'] = true;
					}
					if (isset($side_menu['children'])) {
						foreach ($side_menu['children'] as $key3 => $sub_menu) {
							$menu[$key]['children'][$key2]['children'][$key3]['checked'] = false;
							if (in_array($sub_menu['id'], $items)) {
								$menu[$key]['children'][$key2]['children'][$key3]['checked'] = true;
							}
						}
					}
				}
			}
		}
		return $menu;
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getAuthAssignments()
	{
		return $this->hasMany(AuthAssignment::className(), ['item_name' => 'name']);
	}

	public function getAuthAdmin()
	{
		return $this->hasMany(Admin::className(), ['id' => 'user_id'])->via('authAssignments');
	}
}
