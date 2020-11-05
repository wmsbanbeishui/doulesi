<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\table\AuthItem */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '权限列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('/static/admin/css/index.css');
$this->registerCssFile('/static/admin/css/tree_three.css');
$this->registerJsFile('/static/admin/js/jquery/2.2.4/jquery.min.js');
$this->registerJsFile('/static/admin/js/app.js');
$this->registerJsFile('/static/admin/js/auth_create.js');
?>
<div class="menu-base-view">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?= Html::a('修改权限', ['update', 'id' => $model->name], ['class' => 'btn btn-primary btn-sm']) ?>
		<?= Html::a('删除权限', ['delete', 'id' => $model->name], [
			'class' => 'btn btn-danger btn-sm',
			'data' => [
				'confirm' => '确定要删除这条数据吗？',
				'method' => 'post',
			],
		]) ?>
	</p>

	<div class="menus">

	</div>

	<div class="input-item">
		<label for="input-name">路由：</label>
		<input type="text" name="input-name" id="input-name" value=<?php echo $model->name; ?>/>
	</div>
	<div class="input-item">
		<label for="input-discrib">描述：</label>
		<input type="text" name="input-discrib" id="input-discrib" value=<?php echo $model->description; ?>/>
	</div>
	<div class="input-item">
		<label for="input-discrib">拥有此权限项的角色：</label>
		<?php foreach ($model['parents'] as $role): ?>
			<span><a href="/role/list?role=<?= $role['name'] ?>"><?= $role['description'] ?></a></span>&nbsp;&nbsp;&nbsp;
		<?php endforeach; ?>
	</div>

</div>
<script>
	var menus = <?php echo json_encode($menu); ?>;
	var id = 0;
	var type = "look";
</script>
