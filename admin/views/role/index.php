<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\grid\SerialColumn;

/* @var $this yii\web\View */
/* @var $searchModel admin\models\search\RoleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '角色管理';
$this->params['breadcrumbs'][] = $this->title;
$gridColumns = [
	['class' => SerialColumn::className()],
	'name',
	'description',
	[
		'header' => '角色用户',
		'format' => 'raw',
		'value' => function ($model) {
			$count = count($model['authAdmin']);
			// 只显示最后添加的三个
			$last = array_slice($model['authAdmin'], -3);
			$admin_str = '';
			foreach ($last as $admin) {
				$admin_str .= Html::a($admin['realname'], ['/admin/set-roles', 'id' => $admin['id']]) . ',';
			}
			if ($count > 3) {
				$admin_str .= Html::a('......', ['/role/view', 'id' => $model->name]);
			}
			return trim($admin_str, ',');
		},
	],
	[
		'header' => '角色权限',
		'format' => 'html',
		'value' => function ($model) {
			return Html::a('配置权限', ['/role/list', 'role' => $model->name]);
		},
	],

	['class' => ActionColumn::className()],
];

?>
<div class="auth-index">
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增角色', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => $gridColumns,
	]); ?>
</div>
