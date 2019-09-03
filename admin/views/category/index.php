<?php

use common\helpers\Render;
use common\models\table\Category;
use common\services\LevelService;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel admin\models\search\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '类别列表';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
	'id',
	'name',
	'letter',
	[
		'attribute' => 'level',
		'value' => function ($model) {
			return LevelService::getNameById($model->level);
		}
	],
	[
		'attribute' => 'status',
		'value' => function ($model) {
			return Category::statusMap($model->status);
		}
	],
	'order_index',
	'create_time',
	[
		'class' => 'yii\grid\ActionColumn',
		'template' => '{update}{delete}',
	],
];
?>
<div class="category-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加分类', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

	<?= Render::gridView([
		'dataProvider' => $dataProvider,
		'columns' => $gridColumns,
	]); ?>
</div>
