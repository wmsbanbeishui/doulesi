<?php

use common\models\table\Impulse;
use admin\models\Admin;
use common\widgets\DateRangePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model admin\models\search\ImpulseSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="impulse-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="pl form-inline">

        <?= $form->field($model, 'admin_id')->dropDownList(Admin::map(), ['prompt' => '全部']) ?>

        <?= $form->field($model, 'type')->dropDownList(Impulse::typeMap(), ['prompt' => '请选择', 'id' => 'level'])?>

        <?= $form->field($model, 'date')->widget(DateRangePicker::className()) ?>

        <?= $form->field($model, 'remark') ?>

        <div class="form-group">
            <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
            <div class="help-block"></div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
