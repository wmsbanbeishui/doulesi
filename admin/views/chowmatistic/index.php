<?php

use common\helpers\Render;
use common\models\table\Currency;
use common\models\table\CurrencyCat;
use yii\helpers\Html;

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
			return CurrencyCat::getNameById($model->cat_id);
		}
	],
	'open_interest',
	'final_price',
	'profit',
	'commission',
	[
		'header' => '利润',
		'value' => function ($model) {
			return ($model->profit - $model->commission);
		}
	],
	'rmb',
	[
		'header' => '利润（RMB）',
		'value' => function ($model) {
			return round(($model->profit - $model->commission) * $model->final_price * 7, 2);
		}
	],
	'offset_time',
	'remark',
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
	<div>
		<table class="table table-striped table-bordered" style="width: 400px;">
			<tr>
				<td>收益（RMB）</td>
				<td>手续费（RMB）</td>
				<td>利润（RMB）</td>
			</tr>
			<tr>
				<td><span style="color: orangered"><?= round($sum_profit * 7, 2) ?></span></td>
				<td><span style="color: orangered"><?= round($sum_commission * 7, 2) ?></span></td>
				<td><span style="color: orangered"><?= round(($sum_profit - $sum_commission) * 7, 2)?></span></td>
			</tr>
		</table>
	</div>

    <?= Render::gridView([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumn
    ]); ?>
</div>
