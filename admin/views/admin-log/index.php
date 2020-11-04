<?php

use common\models\table\Admin;
use common\models\table\AdminLog;
use common\models\table\AdminMenu;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\AdminLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '管理员日志';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-log-index">
	<?php echo $this->render('_search', ['model' => $searchModel]); ?>
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		// 'filterModel' => $searchModel,
		'columns' => [
			// ['class' => 'yii\grid\SerialColumn'],

			'id',
			[
				'attribute' => 'admin_id',
				'header' => '管理员',
				'value' => function ($model) {
					return Admin::find()->select(['realname'])->where(['id' => $model->admin_id])->scalar();
				},
			],
			[
				'attribute' => 'menu_id',
				'header' => '菜单',
				'value' => function ($model) {
					return AdminMenu::find()->select(['name'])->where(['id' => $model->menu_id])->scalar();
				},
			],
			[
				'attribute' => 'action',
				'header' => '操作',
				'value' => function ($model) {
					return AdminLog::actionMap($model->action);
				},
			],
			'table',
			'record_id',
			'field',
			[
				'attribute' => 'origin',
				'value' => function ($model) {
					return mb_strlen($model->origin) > 20 ? mb_substr($model->origin, 0, 20).'...' : $model->origin;
				},
			],
			[
				'attribute' => 'new',
				'value' => function ($model) {
					return mb_strlen($model->new) > 20 ? mb_substr($model->new, 0, 20).'...' : $model->new;
				},
			],
			'create_time',
			[
				'header' => '查看',
				'header' => '操作',
				'format' => 'raw',
				'value' => function ($model) {
					return Html::a('查看', ['view', 'id' => $model->id], ['class' => 'btn btn-xs btn-success']);
				},
			],
		],
	]); ?>
</div>
