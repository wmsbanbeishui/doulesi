<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '配置权限 / role='.$role;
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('/static/admin/css/index.css');
$this->registerCssFile('/static/admin/css/tree_three.css');
$this->registerJsFile('/static/admin/js/jquery/2.2.4/jquery.min.js');
$this->registerJsFile('/static/admin/js/app.js');
$this->registerJsFile('/static/admin/js/permissions.js');
?>
<div class="menus">

</div>
<div class="submit-sure">
	<button class="btn press-color">提交</button>
</div>
<script>
	var menus = <?php echo json_encode($menu); ?>;
	var role = <?php echo "'$role'" ?>;
</script>
