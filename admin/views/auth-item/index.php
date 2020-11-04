<?php

use common\widgets\grid\SerialColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel admin\models\search\AuthItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '权限列表';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
	'name',
	'description:ntext',

	[
		'class' => 'yii\grid\ActionColumn',
		'template' => '{view} {update} {delete}',
	],
];
?>
<div class="auth-item-index">
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增权限', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => $gridColumns,
	]); ?>
</div>
