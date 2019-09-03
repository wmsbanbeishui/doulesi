<?php

use common\models\table\Level;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model admin\models\search\LevelSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="level-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
	<div class="pl form-inline">

		<?= $form->field($model, 'name') ?>

		<?= $form->field($model, 'status')->dropDownlist(Level::statusMap(), ['prompt' => '全部']) ?>

		<div class="form-group">
			<?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
			<?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
			<div class="help-block"></div>
		</div>

	</div>

    <?php ActiveForm::end(); ?>

</div>
