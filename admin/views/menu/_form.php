<?php

use admin\models\AdminMenu;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

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

    <?= $form->field($model, 'pid')->dropDownList(AdminMenu::getLevelMap()) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'uri')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'icon')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_index')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList(AdminMenu::statusMap()) ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton($model->isNewRecord ? '新增' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success btn-sm' : 'btn btn-primary btn-sm']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
