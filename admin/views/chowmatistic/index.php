<?php

use common\helpers\Render;
use common\models\table\Chowmatistic;
use common\models\table\Currency;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel admin\models\search\ChowmatisticSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '交易列表';
$this->params['breadcrumbs'][] = $this->title;

$gridColumn = [
	'id',
	[
		'attribute' => 'cur_id',
		'value' => function ($model) {
			return Currency::map($model->cur_id);
		}
	],
	[
		'attribute' => 'cat_id',
		'value' => function ($model) {
			return Chowmatistic::catMap($model->cat_id);
		}
	],
	'open_interest',
	'profit',
	'commission',
	[
		'header' => '净利润',
		'value' => function ($model) {
			return $model->profit - $model->commission;
		}
	],
	'offset_time',
	'remark',
	'create_time',
	[
		'class' => 'yii\grid\ActionColumn',
		'template' => '{update} {delete}',
	],
];
?>
<div class="chowmatistic-index">
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增交易', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= Render::gridView([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumn
    ]); ?>
</div>
