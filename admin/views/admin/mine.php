<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\JsBlock;
use common\services\QiniuService;

/* @var $this yii\web\View */
/* @var $model admin\models\Admin */

$this->title = '修改个人信息';
$this->params['breadcrumbs'][] = $this->title;

$avatar = '/static/admin/images/test_icon.png';
if (!empty($model->avatar)) {
	$avatar = $model->avatar;
	if ($avatar[0] != '/') {
		$avatar = QiniuService::get_img_url($avatar);
	}
}

?>
<div class="admin-update">

	<?php $form = ActiveForm::begin([
		'options' => [
			'class' => ['form-horizontal'],
			'enctype' => 'multipart/form-data',
		],
		'method' => 'post',
		'fieldConfig' => [
			'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
			'labelOptions' => ['class' => ['control-label', 'col-lg-1']],
		],
	]); ?>
	<div class="row" style="padding-bottom: 10px;">
		<label class="col-lg-1 text-right" style="padding:10px 15px">头像</label>
		<div class="col-lg-3">
			<img id="pic" src="<?= $avatar ?>" title="点击选择图片" width=40 class="img-responsive"/>
		</div>
		<div class="col-lg-">
			<input id="upload" name="avatar" accept="image/*" type="file" style="display: none"/>
		</div>
	</div>

	<?= $form->field($model, 'mobile')->textInput(['maxlength' => true, 'readonly' => 'readonly']) ?>

	<?= $form->field($model, 'realname')->textInput(['maxlength' => true, 'readonly' => 'readonly']) ?>

	<?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

	<div class="form-group">
		<div class="col-lg-offset-1 col-lg-11">
			<?= Html::submitButton('修改', ['class' => 'btn btn-primary btn-sm']) ?>
		</div>
	</div>

	<?php ActiveForm::end(); ?>

</div>
<?php JsBlock::begin() ?>
<script type="text/javascript">
	$(function () {
		$("#pic").click(function () {
			$("#upload").click();
		});
		$("#upload").on("change", function () {
			var objUrl = getObjectURL(this.files[0]);
			if (objUrl) {
				$("#pic").attr("src", objUrl); //将图片路径存入src中，显示出图片
			}
		});
	})

	function getObjectURL(file) {
		var url = null;
		if (window.createObjectURL != undefined) { // basic
			url = window.createObjectURL(file);
		} else if (window.URL != undefined) { // mozilla(firefox)
			url = window.URL.createObjectURL(file);
		} else if (window.webkitURL != undefined) { // webkit or chrome
			url = window.webkitURL.createObjectURL(file);
		}
		return url;
	}
</script>
<?php JsBlock::end() ?>
