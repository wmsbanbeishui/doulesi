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
		'header' => '利润(币)',
		'value' => function ($model) {
			return ($model->profit - $model->commission);
		}
	],
	'rmb',
	[
		'header' => '利润(人民币)',
		'value' => function ($model) {
			return round(($model->profit - $model->commission) * $model->rmb, 2);
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

    <?= Render::gridView([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumn
    ]); ?>
</div>
