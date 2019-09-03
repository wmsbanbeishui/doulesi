
<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '权限管理';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('/static/admin/css/index.css');
$this->registerCssFile('/static/admin/css/tree_three.css');
$this->registerJsFile('/static/admin/js/jquery/2.2.4/jquery.min.js');
$this->registerJsFile('/static/admin/js/user_permiss.js');
?>
<div class="menus">

</div>
<script>
	var menus = <?php echo json_encode($menu); ?>;
</script>
