<?php

use common\models\table\Category;
use common\models\table\Level;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\table\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

	<?php $form = ActiveForm::begin([
		'options' => [
			'class' => ['form-horizontal'],
		],
		'fieldConfig' => [
			'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
			'labelOptions' => ['class' => ['control-label', 'col-lg-1']],
		],
	]); ?>

	<?= $form->field($model, 'level')->dropDownlist(Level::map()) ?>

	<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'letter')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'status')->dropDownList(Category::statusMap()) ?>

	<?= $form->field($model, 'order_index')->textInput() ?>

    <div class="form-group">
		<div class="col-lg-offset-1 col-lg-11">
        	<?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
		</div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
