<?php

use admin\models\Admin;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\table\Record */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="record-form">

	<?php $form = ActiveForm::begin([
		'options' => [
			'class' => ['form-horizontal'],
		],
		'fieldConfig' => [
			'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
			'labelOptions' => ['class' => ['control-label', 'col-lg-1']],
		],
	]); ?>

	<?= $form->field($model, 'admin_id')->dropDownList(Admin::map()) ?>

	<div class="form-group">
		<label class="control-label col-lg-1">日期</label>
		<div class="col-lg-3">
			<?php echo DatePicker::widget([
				'name' => 'Record[date]',
				'value' => $model->isNewRecord ? date('Y-m-d') : $model->date,
				'options' => ['id' => 'RecordDate', 'placeholder' => ''],
				'pluginOptions' => [
					'format' => 'yyyy-mm-dd',
					'todayHighlight' => true,
				],
			]); ?>
		</div>
		<div class="col-lg-8">
			<div class="help-block"></div>
		</div>
	</div>

    <?= $form->field($model, 'record')->textarea(['maxlength' => true]) ?>

    <div class="form-group">
		<div class="col-lg-offset-1 col-lg-11">
        	<?= Html::submitButton($model->isNewRecord ? '新增' : '修改', ['class' => 'btn btn-success']) ?>
		</div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
