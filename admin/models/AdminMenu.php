<?php

namespace admin\models;

use common\models\base\AdminMenuBase;
use common\models\base\AuthAssignment;
use common\models\base\AuthItemAuthItemChild;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class AdminMenu extends AdminMenuBase {
    const STATUS_ENABLE = 1;
    const STATUS_DISABLE = 0;

    public static $menutree = null;

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'pid' => '父菜单',
            'name' => '菜单名称',
            'uri' => '路由地址',
            'icon' => '图标',
            'order_index' => '排序值',
            'status' => '状态',
            'description' => '功能说明',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }

    public function scenarios() {
        return Model::scenarios();
    }

    public function search($params) {
        $query = self::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['pid' => SORT_ASC, 'order_index' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
                'pid' => $this->pid,
                'status' => $this->status,
            ]);

        $query->andFilterWhere([
                    'OR',
                    ['like', 'name', $this->name],
                    ['like', 'description', $this->name],
                ])
              ->andFilterWhere(['like', 'uri', $this->uri]);

        return $dataProvider;
    }

    public static function getLevelMap() {
        $data = self::find()
            ->select(['id', 'name'])
            ->where(['pid' => 0])
            ->orderBy(['order_index' => SORT_DESC])
            ->all();
        return ArrayHelper::merge(['0' => '--'], ArrayHelper::map($data, 'id', 'name'));
    }

    public static function getMenuMap($menu_id = null) {
        if (empty(self::$menutree)) {
            self::$menutree = self::tree([]);
        }
        $tree = self::$menutree;
        $menu = [0 => '-'];
        foreach ($tree as $top_menu) {
            $top_menu_id = $top_menu['id'];
            $menu[$top_menu_id] = $top_menu['name'];
            if (!isset($top_menu['children'])) {
                continue;
            }
            foreach ($top_menu['children'] as $side_menu) {
                $side_menu_id = $side_menu['id'];
                $menu[$side_menu_id] = $side_menu['name'];
                if (!isset($side_menu['children'])) {
                    continue;
                }
                foreach ($side_menu['children'] as $sub_menu) {
                    $sub_menu_id = $sub_menu['id'];
                    $menu[$sub_menu_id] = $sub_menu['name'];
                }
            }
        }

        if (!is_null($menu_id)) {
            if (isset($menu[$menu_id])) {
                return $menu[$menu_id];
            } else {
                return null;
            }
        }

        return $menu;
    }

    public static function statusMap($value = -1) {
        $map = [
            self::STATUS_ENABLE => '已启用',
            self::STATUS_DISABLE => '已禁用',
        ];
        if ($value == -1) {
            return $map;
        }
        return ArrayHelper::getValue($map, $value, $value);
    }

    public static function tree($condition = ['status' => 1]) {
        $tree = [];
        $list = self::find()->where($condition)->orderBy(['pid' => SORT_DESC, 'order_index' => SORT_DESC])->all();
        $list = ArrayHelper::toArray($list);

        $tree = [];
        foreach ($list as $menu) {
            $tree[$menu['id']] = $menu;
        }

        foreach ($list as $menu) {
            $id = $menu['id'];
            $pid = $menu['pid'];
            $menu = $tree[$id];
            if (!$pid) {
                continue;
            }
            if (!isset($tree[$pid])) {
                continue;
            }
            if (!isset($tree[$pid]['children'])) {
                $tree[$pid]['children'] = [];
            }
            $tree[$pid]['children'][] = $menu;
            unset($tree[$id]);
        }

        return $tree;
    }

    public static function personMenu($user_id) {
        $data = AdminMenu::find()->where(['status' => AdminMenu::STATUS_ENABLE])
            ->orderBy(['pid' => SORT_ASC, 'order_index' => SORT_DESC, 'id' => SORT_ASC])
            ->all();
        $menu = [];
        foreach ($data as $obj) {
            if ($obj->pid == 0) {
                $menu[$obj->id] = ['name' => $obj->name, 'icon' => $obj->icon, 'children' => []];
            } else {
                if (isset($menu[$obj->pid])) {
                    $menu[$obj->pid]['children'][] = ['name' => $obj->name, 'icon' => $obj->icon, 'uri' => $obj->uri];
                }
            }
        }

        if ($user_id == 1) {
            return $menu;
        }

        $item = AuthAssignment::find()->select(['item_name'])->where(['user_id' => $user_id])->column();
        $child = AuthItemAuthItemChild::find()->select('child')->where(['parent' => $item])->column();
        array_unique($child);

        foreach ($menu as $key => $val) {
            foreach ($menu[$key]['children'] as $k => $v) {
                if (!in_array($v['uri'], $child)) {
                    unset($menu[$key]['children'][$k]);
                }
            }
            if (empty($menu[$key]['children'])) {
                unset($menu[$key]);
            }
        }

        return $menu;
    }

    public static function simpleMenu(){
		$data = AdminMenu::find()->where(['status' => AdminMenu::STATUS_ENABLE])
			->orderBy(['pid' => SORT_ASC, 'order_index' => SORT_DESC, 'id' => SORT_ASC])
			->all();
		$menus = [];
		foreach ($data as $item) {
			if ($item->pid == 0) {
				$menus[$item->id] = ['id' => $item->id, 'name' => $item->name, 'children' => []];
			} else {
				if (isset($menus[$item->pid])) {
					$menus[$item->pid]['children'][] = ['id' => $item->id, 'name' => $item->name];
				}
			}
		}
		return $menus;
	}

	//数据层级格式化
	public static $newArray = array();
	public static function arrayFormat($array, $pid = 0, $space = '&nbsp;&nbsp;')
	{
		if(empty($array))	return false;
		foreach ($array as $key=>&$val)
		{
			if($pid == $val['pid'])
			{
				$array[$key]['Space'] = $space;
				self::$newArray[] = $val;
				unset($array[$key]);
				self::arrayFormat($array, $val['id'], $space . "─");
			}
		}
		return self::$newArray;
	}
}
