<?php

use common\models\table\Salary;
use admin\models\Admin;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\table\Salary */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="salary-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => ['form-horizontal'],
        ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => ['control-label', 'col-lg-1']],
        ],
    ]); ?>

    <?= $form->field($model, 'admin_id')->dropDownList(Admin::map()) ?>

    <div class="form-group">
        <label class="control-label col-lg-1">日期</label>
        <div class="col-lg-3">
            <?php echo DatePicker::widget([
                'name' => 'Salary[date]',
                'value' => $model->isNewRecord ? date('Y-m-d') : $model->date,
                'options' => ['id' => 'SalaryDate', 'placeholder' => ''],
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

    <?= $form->field($model, 'salary')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(Salary::statusMap()) ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
