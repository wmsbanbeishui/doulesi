<?php

use common\widgets\DateRangePicker;
use common\models\table\Currency;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model admin\models\search\FinanceSearch */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="finance-search">

	<?php $form = ActiveForm::begin([
		'action' => ['chart'],
		'method' => 'get',
	]); ?>

	<div class="pl form-inline">

		<?= $form->field($model, 'cur_id')->dropDownList(Currency::map(), ['prompt' => '请选择'])?>

		<?= $form->field($model, 'offset_time')->widget(DateRangePicker::className()) ?>

		<div class="form-group">
			<?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
			<?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
			<div class="help-block"></div>
		</div>
	</div>

	<?php ActiveForm::end(); ?>

</div>

