<?php

use common\widgets\DateRangePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model admin\models\search\WorkLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="work-log-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'class' => ['form-inline'],
        ]
    ]); ?>

    <?= $form->field($model, 'date')->widget(DateRangePicker::className()) ?>

    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
        <div class="help-block"></div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
