<?php

use common\helpers\Render;
use common\models\table\Currency;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel admin\models\search\CurrencySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '币种列表';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
	'id',
	'name',
	[
		'attribute' => 'status',
		'value' => function ($model) {
			return Currency::statusMap($model->status);
		}
	],
	'order_index',
	'create_time',
	[
		'class' => 'yii\grid\ActionColumn',
		'template' => '{update} {delete}',
	],
];
?>
<div class="currency-index" style="width:1000px;">
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增币种', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

	<?= Render::gridView([
		'dataProvider' => $dataProvider,
		'columns' => $gridColumns,
	]); ?>
</div>
