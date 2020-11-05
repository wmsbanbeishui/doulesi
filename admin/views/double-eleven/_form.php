<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\table\DoubleEleven */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="double-eleven-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => ['form-horizontal'],
        ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => ['control-label', 'col-lg-1']],
        ],
    ]); ?>

    <div class="form-group">
        <label class="control-label col-lg-1">日期</label>
        <div class="col-lg-3">
            <?php echo DatePicker::widget([
                'name' => 'DoubleEleven[date]',
                'value' => $model->isNewRecord ? date('Y') : $model->year,
                'options' => ['id' => 'DoubleElevenDate', 'placeholder' => ''],
                'pluginOptions' => [
                    'format' => 'yyyy',
                    'todayHighlight' => true,
                ],
            ]); ?>
        </div>
        <div class="col-lg-8">
            <div class="help-block"></div>
        </div>
    </div>

    <?= $form->field($model, 'product')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
