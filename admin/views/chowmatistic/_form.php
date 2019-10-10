<?php

use common\models\table\Chowmatistic;
use common\models\table\Currency;
use common\models\table\CurrencyCat;
use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\table\Chowmatistic */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="chowmatistic-form">

	<?php $form = ActiveForm::begin([
		'options' => [
			'class' => ['form-horizontal'],
		],
		'fieldConfig' => [
			'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
			'labelOptions' => ['class' => ['control-label', 'col-lg-1']],
		],
	]); ?>

    <?= $form->field($model, 'cur_id')->dropDownList(Currency::map()) ?>

    <?= $form->field($model, 'cat_id')->dropDownList(CurrencyCat::map()) ?>

    <?= $form->field($model, 'open_interest')->textInput() ?>

	<?= $form->field($model, 'final_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'profit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'commission')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'rmb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>

	<div class="form-group">
		<label class="control-label col-lg-1">时间</label>
		<div class="col-lg-3">
			<?php echo DateTimePicker::widget([
				'name' => 'Chowmatistic[offset_time]',
				'value' => $model->isNewRecord ? date('Y-m-d H:i:s') : $model->offset_time,
				'options' => ['id' => 'Chowmatistic', 'placeholder' => ''],
				'pluginOptions' => [
					'format' => 'yyyy-mm-dd hh:ii:ss',
					'todayHighlight' => true,
				],
			]); ?>
		</div>
		<div class="col-lg-8">
			<div class="help-block"></div>
		</div>
	</div>

    <div class="form-group">
		<div class="col-lg-offset-1 col-lg-11">
        	<?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
		</div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
