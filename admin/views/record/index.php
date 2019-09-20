<?php

use common\helpers\Helper;
use common\helpers\Render;
use common\services\AdminService;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel admin\models\search\RecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '记事本';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
	'id',
	'date',
	[
		'attribute' => 'date',
		'header' => '星期',
		'value' => function ($model) {
			return Helper::getWeekByDate($model->date);
		}
	],
	[
		'attribute' => 'admin_id',
		'value' => function ($model) {
			return AdminService::getNameById($model->admin_id);
		}
	],
	[
		'attribute' => 'record',
		'value' => function ($model) {
			return $model->record;
		},
		'contentOptions' => [
			'style' => 'white-space:normal;word-wrap:break-word;word-break:break-all;width:650px;text-align:left;padding-left:30px',
		],
	],
	'create_time',
	[
		'class' => 'yii\grid\ActionColumn',
		'template' => '{update} {delete}',
	]
];
?>
<div class="record-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新建记事', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

	<?= Render::gridView([
		'dataProvider' => $dataProvider,
		'columns' => $gridColumns,
		'export_columns' => $gridColumns,
		'export' => [
			'filename' => 'record'.date('Y-m-d'),
		],
	]); ?>
</div>
