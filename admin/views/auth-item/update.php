<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\table\AuthItem */

$this->title = 'Update Auth Item: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => '权限列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = '更新';

$this->registerCssFile('/static/admin/css/index.css');
$this->registerCssFile('/static/admin/css/tree_three.css');
$this->registerJsFile('/static/admin/js/jquery/2.2.4/jquery.min.js');
$this->registerJsFile('/static/admin/js/app.js');
$this->registerJsFile('/static/admin/js/auth_create.js');
?>
<div class="menu-base-update">
	<div class="menus">

	</div>

	<div class="input-item">
		<label for="input-name">路由：</label>
		<input type="text" name="input-name" id="input-name" value=<?php echo $model->name;?>  />
	</div>
	<div class="input-item">
		<label for="input-discrib">描述：</label>
		<input type="text" name="input-discrib" id="input-discrib" value=<?php echo $model->description;?>  />
	</div>
	<div class="submit-sure">
		<button class="btn press-color">提交</button>
	</div>

</div>

<script>
	var menus = <?php echo json_encode($menu); ?>;
	var id = <?php echo "'$model->name'"; ?>;
	var type = "update";
</script>
