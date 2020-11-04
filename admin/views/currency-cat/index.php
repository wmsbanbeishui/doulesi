<?php

use common\helpers\Render;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '类别列表';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
	'id',
	'name',
	'order_index',
	'create_time',
	[
		'class' => 'yii\grid\ActionColumn',
		'template' => '{update} {delete}',
	],
];
?>
<div class="currency-cat-index">

    <p>
        <?= Html::a('添加分类', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

	<?= Render::gridView([
		'dataProvider' => $dataProvider,
		'columns' => $gridColumns,
	]); ?>
</div>
