<?php

use admin\models\Admin;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$status = Admin::statusMap();

$model->password = '';
?>

<div class="user-form">

	<?php $form = ActiveForm::begin([
		'options' => [
			'class' => ['form-horizontal'],
		],
		'fieldConfig' => [
			'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
			'labelOptions' => ['class' => ['control-label', 'col-lg-1']],
		],
	]); ?>

	<?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'password')->textInput(['maxlength' => true , 'class' => 'gen-pass form-control']) ?>

	<?= $form->field($model, 'realname')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'status')->dropDownList($status) ?>

	<div class="form-group">
		<div class="col-lg-offset-1 col-lg-11">
			<?= Html::submitButton($model->isNewRecord ? '创建' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success btn-sm' : 'btn btn-primary btn-sm']) ?>
		</div>
	</div>

	<?php ActiveForm::end(); ?>

</div>


