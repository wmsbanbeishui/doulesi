<?php

use common\models\table\Currency;
use common\models\table\CurrencyCat;
use common\widgets\DateRangePicker;
use common\models\table\Chowmatistic;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model admin\models\search\ChowmatisticSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="chowmatistic-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

	<div class="pl form-inline">

		<?= $form->field($model, 'cur_id')->dropDownList(Currency::map(), ['prompt' => '全部']) ?>

		<?= $form->field($model, 'cat_id')->dropDownList(CurrencyCat::map(), ['prompt' => '全部']) ?>

		<?= $form->field($model, 'offset_time')->widget(DateRangePicker::className()) ?>

		<?= $form->field($model, 'remark') ?>

		<div class="form-group">
			<?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
			<?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
			<div class="help-block"></div>
		</div>
	</div>

    <?php ActiveForm::end(); ?>

</div>
