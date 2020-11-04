<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\table\AuthItem */

$this->title = '新增权限';
$this->params['breadcrumbs'][] = ['label' => '权限列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('/static/admin/css/index.css');
$this->registerCssFile('/static/admin/css/tree_three.css');
$this->registerJsFile('/static/admin/js/jquery/2.2.4/jquery.min.js');
$this->registerJsFile('/static/admin/js/app.js');
$this->registerJsFile('/static/admin/js/auth_create.js');
?>
<div class="menu-base-create">
	<div class="menus">

	</div>

	<div class="input-item">
		<label for="input-name">路由：</label>
		<input type="text" name="input-name" id="input-name" value=""  />
	</div>
	<div class="input-item">
		<label for="input-discrib">描述：</label>
		<input type="text" name="input-discrib" id="input-discrib" value=""  />
	</div>
	<div class="submit-sure">
		<button class="btn press-color">提交</button>
	</div>


</div>
<script>
	var menus = <?php echo json_encode($menu); ?>;
	var id = 0;
	var type = "create";
</script>
