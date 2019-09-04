<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Admin */

$this->title = '修改密码';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-update">

	<?php $form = ActiveForm::begin([
		'options' => [
			'class' => ['form-horizontal'],
		],
		'fieldConfig' => [
			'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
			'labelOptions' => ['class' => ['control-label', 'col-lg-1']],
		],
	]); ?>

	<?= $form->field($model, 'old_password')->passwordInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'new_password')->passwordInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'rep_passwor')->passwordInput(['maxlength' => true]) ?>

	<div class="form-group">
		<div class="col-lg-offset-1 col-lg-11">
			<?= Html::submitButton('修改', ['class' => 'btn btn-primary btn-sm']) ?>
		</div>
	</div>

	<?php ActiveForm::end(); ?>

</div>
