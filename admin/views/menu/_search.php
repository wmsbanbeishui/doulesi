<?php
use admin\models\AdminMenu;
use common\helpers\Helper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="notice-form">
	<?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',
		'options' => [
			'class' => ['form-inline'],
		],
	]); ?>

	<?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => '菜单名或描述'])->label('关键字')?>
	<?= $form->field($model, 'uri')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'status')->dropDownList(AdminMenu::statusMap(), ['prompt' => '全部'])->label('状态') ?>

	<div class="form-group">
		<?= Html::submitButton('搜索', ['class' => 'btn btn-primary btn-sm']) ?>
		<?= Html::resetButton('重置', ['class' => 'btn btn-default btn-sm']) ?>
		<?= Html::a('新增菜单', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
		<div class="help-block"> </div>
	</div>

	<?php ActiveForm::end(); ?>

</div>
