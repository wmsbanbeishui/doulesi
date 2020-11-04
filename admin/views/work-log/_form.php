<?php

use kucha\ueditor\UEditor;
use kartik\date\DatePicker;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\table\WorkLog */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="work-log-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => ['form-horizontal'],
        ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-6\">{input}</div>\n<div class=\"col-lg-5\">{error}</div>",
            'labelOptions' => ['class' => ['control-label', 'col-lg-1']],
        ],
    ]); ?>

    <div class="form-group">
        <label class="control-label col-lg-1">日期</label>
        <div class="col-lg-3">
            <?php echo DatePicker::widget([
                'name' => 'WorkLog[date]',
                'value' => $model->isNewRecord ? date('Y-m-d') : $model->date,
                'options' => ['id' => 'WorkLogDate', 'placeholder' => ''],
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

    <?= $form->field($model, 'plan')->widget(UEditor::className(), [
        'clientOptions' => [
            'serverUrl' => Url::to(['/work-log/ue-upload']),
            'autoHeightEnabled ' => false,
            'autoFloatEnabled' => false,
        ],
    ]) ?>

    <?= $form->field($model, 'finish')->widget(UEditor::className(), [
        'clientOptions' => [
            'serverUrl' => Url::to(['/work-log/ue-upload']),
            'autoHeightEnabled ' => false,
            'autoFloatEnabled' => false,
        ],
    ]) ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
