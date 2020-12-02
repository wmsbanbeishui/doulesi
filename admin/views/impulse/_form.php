<?php

use admin\models\Admin;
use common\models\table\Impulse;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\table\Impulse */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="impulse-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => ['form-horizontal'],
        ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => ['control-label', 'col-lg-1']],
        ],
    ]); ?>

    <?= $form->field($model, 'type')->dropDownList(Impulse::typeMap()) ?>

    <?= $form->field($model, 'admin_id')->dropDownList(Admin::map()) ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <label class="control-label col-lg-1">日期</label>
        <div class="col-lg-3">
            <?php echo DatePicker::widget([
                'name' => 'Impulse[date]',
                'value' => $model->isNewRecord ? date('Y-m-d') : $model->date,
                'options' => ['id' => 'ImpulseDate', 'placeholder' => ''],
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

    <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
