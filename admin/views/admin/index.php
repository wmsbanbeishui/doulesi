<?php

use common\models\table\AuthAssignment;
use common\models\table\Admin;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = '后台用户管理';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
	// ['class' => 'yii\grid\SerialColumn'],

	'id',
	'username',
	[
		'attribute' => 'realname',
		'format' => 'raw',
		'value' => function ($model) {
			return $model->realname;
		},
	],
	'mobile',
	[
		'attribute' => 'status',
		'format' => 'raw',
		'value' => function ($model) {
			return Admin::statusMap($model->status);
		},
	],
	[
		'header' => '拥有角色',
		'format' => 'raw',
		'value' => function ($model) {
			$auth_str = '';
			$auths_list = AuthAssignment::find()->select(['i.description', 'item_name'])->joinWith(['itemName i'])->where(['user_id' => $model->id])->asArray()->all();
			if (empty($auths_list)) {
				return null;
			} else {
				foreach ($auths_list as $key => $auth) {
					if ($key > 2) {
						$auth_str .= Html::a('......', ['/admin/view', 'id' => $model->id]);
						break;
					} else {
						$auth_str .= Html::a($auth['description'], ['/role/list', 'role' => $auth['item_name']]) . ',';
					}
				}
				return trim($auth_str, ',');
			}
		},
	],
	[
		'header' => '设置角色',
		'format' => 'raw',
		'value' => function ($model) {
			return Html::a('设置角色', ['set-roles', 'id' => $model->id]);
		},
	],
	[
		'header' => '用户权限',
		'format' => 'raw',
		'value' => function ($model) {
			return Html::a('查看用户权限', ['get-user-auth', 'id' => $model->id]);
		},
	],
	'create_time',
	// 'update_time',

	[
		'class' => 'yii\grid\ActionColumn',
		'template' => '{update} {delete}',
	],
]

?>

<div class="admin-index">
	<p>
		<?= Html::a('添加后台用户', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
	</p>
	<p>
	</p>
	<?php // echo $this->render('_search', ['model' => $searchModel]);?>
	<?php //= Render::gridView($dataProvider, $gridColumns)?>
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => $gridColumns,
	]); ?>
</div>
