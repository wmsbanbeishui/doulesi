<?php
use admin\models\form\VersionForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$port_name = VersionForm::portMap($model->port);
$this->title = 'CDN路径设置:'.$port_name;
$this->params['breadcrumbs'][] = ['label' => '版本号设置', 'url' => 'version-list'];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="menu-base-update">
<div class="menu-base-form">

    <?php $form = ActiveForm::begin([
		'options' => [
			'class' => ['form-horizontal'],
		],
		'fieldConfig' => [
			'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
			'labelOptions' => ['class' => ['control-label', 'col-lg-1']],
		],
	]); ?>


	<?= $form->field($model, 'port')->hiddenInput(['maxlength' => true])->label($port_name) ?>
    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('保存', ['class' => 'btn btn-primary btn-sm']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
