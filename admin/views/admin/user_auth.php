
<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '权限管理';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile(CDN_URL.'/static/admin/css/index.css?'.VER);
$this->registerCssFile(CDN_URL.'/static/admin/css/tree_three.css?'.VER);
$this->registerJsFile(CDN_URL.'/static/admin/js/jquery/2.2.4/jquery.min.js?'.VER);
$this->registerJsFile(CDN_URL.'/static/admin/js/user_permiss.js?'.VER);
?>
<div class="menus">

</div>
<script>
	var menus = <?php echo json_encode($menu); ?>;
</script>