<?php

use common\helpers\Render;
use common\models\table\Level;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel admin\models\search\LevelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '等级列表';
$this->params['breadcrumbs'][] = $this->title;

$admin_id = Yii::$app->user->getId();
$role = Yii::$app->authManager->getRolesByUser($admin_id);

$gridColumns = [
	'id',
	'name',
	[
		'attribute' => 'status',
		'value' => function($model) {
			return Level::statusMap($model->status);
		}
	],
	'order_index',
	'create_time',
	[
		'class' => 'yii\grid\ActionColumn',
		'template' => $role == 'admin' || $admin_id == 1 ? '{update} {delete}' : '',
	],
];
?>
<div class="level-index" style="width:1000px;">
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建等级', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

	<?= Render::gridView([
		'dataProvider' => $dataProvider,
		'columns' => $gridColumns,
	]); ?>
</div>
