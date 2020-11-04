<?php

use common\models\table\Admin;
use common\models\table\AdminLog;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$data = Admin::find()->asArray()->select(['id', 'realname'])->all();
$admins = ArrayHelper::map($data, 'id', 'realname');

/* @var $this yii\web\View */
/* @var $model backend\models\search\AdminLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-log-search">

	<?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',
	]); ?>
	<div class="form-inline">
		<?= $form->field($model, 'id')->textInput(['type' => 'number', 'style' => 'width:60px;']) ?>

		<?= $form->field($model, 'admin_id')->dropDownList($admins, ['prompt' => '全部'])->label('管理员') ?>

		<?= $form->field($model, 'action')->dropDownList(AdminLog::actionMap(), ['prompt' => '全部'])->label('操作') ?>

		<?= $form->field($model, 'table') ?>

		<?= $form->field($model, 'field') ?>

		<?= $form->field($model, 'record_id')->textInput(['type' => 'number', 'min' => 0]) ?>
	</div>

	<div class="form-inline">

		<div class="form-group">
			<label>起始时间：</label>
			<?php
			echo DatePicker::widget([
				'name' => 'AdminLogSearch[begin_time]',
				'value' => $model->begin_time,
				'options' => ['placeholder' => '起始时间'],
				'pluginOptions' => [
					'format' => 'yyyy-mm-dd',
					'todayHighlight' => true,
				],
			]);
			?>
			<div class="help-block"></div>
		</div>

		<div class="form-group">
			<label>结束时间：</label>
			<?php
			echo DatePicker::widget([
				'name' => 'AdminLogSearch[end_time]',
				'value' => $model->end_time,
				'options' => ['placeholder' => '结束时间'],
				'pluginOptions' => [
					'format' => 'yyyy-mm-dd',
					'todayHighlight' => true,
				],
			]);
			?>
			<div class="help-block"></div>
		</div>

		<div class="form-group">
			<?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
			<div class="help-block"></div>
		</div>
	</div>
	<?php ActiveForm::end(); ?>

</div>
