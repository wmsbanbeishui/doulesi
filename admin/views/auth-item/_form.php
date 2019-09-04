<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\table\AuthItem */
/* @var $form yii\widgets\ActiveForm */

$this->registerCssFile('/static/admin/css/index.css');
$this->registerCssFile('/static/admin/css/three_tree.css');
$this->registerJsFile('/static/admin/js/jquery/2.2.4/jquery.min.js');
$this->registerJsFile('/static/admin/js/app.js');
$this->registerJsFile('/static/admin/js/permissions.js');

?>

<div class="auth-item-form">

	<?php $form = ActiveForm::begin([
		'options' => [
			'class' => ['form-horizontal'],
		],
		'fieldConfig' => [
			'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
			'labelOptions' => ['class' => ['control-label', 'col-lg-1']],
		],
	]); ?>
	<div class="menus"></div>
	<div class="submit-sure">
		<button class="btn press-color">提交</button>
	</div>

    <?= $form->field($model, 'type', ['template' => '{input}'])->hiddenInput(['value' => 2]) ?>

	<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
		<div class="col-lg-offset-1 col-lg-11">
        	<?= Html::submitButton($model->isNewRecord ? '新增' : '修改', ['class' => 'btn btn-success']) ?>
		</div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
