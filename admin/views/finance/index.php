<?php

use common\helpers\Render;
use common\services\AdminService;
use common\services\CategoryService;
use common\services\LevelService;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel admin\models\search\FinanceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '账单';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
	'id',
	'date',
	[
		'attribute' => 'admin_id',
		'value' => function ($model) {
			return AdminService::getNameById($model->admin_id);
		}
	],
	[
		'attribute' => 'level_id',
		'value' => function ($model) {
			return LevelService::getNameById($model->level_id);
		}
	],
	[
		'attribute' => 'cat_id',
		'value' => function ($model) {
			return CategoryService::getNameById($model->cat_id);
		}
	],
	'cost',
	'create_time',
	[
		'attribute' => 'remark',
		'value' => function ($model) {
			return $model->remark;
		},
		'contentOptions' => [
			'style' => 'white-space:normal;word-wrap:break-word;word-break:break-all;width:350px;text-align:left;padding-left:30px',
		],
	],
	[
		'class' => 'yii\grid\ActionColumn',
		'template' => '{update} {delete}',
	],
];
?>
<div class="finance-index">
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加明细', ['create'], ['class' => 'btn btn-success']) ?>
		<span style="color:red; padding-left: 20px">总计：<?= $sum_cost ?></span>
    </p>

	<?= Render::gridView([
		'dataProvider' => $dataProvider,
		'columns' => $gridColumns,
		'export_columns' => $gridColumns,
		'export' => [
			'filename' => 'finance'.date('Y-m-d'),
		],
	]); ?>
</div>
