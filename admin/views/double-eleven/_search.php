<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model admin\models\search\DoubleElevenSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="double-eleven-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="pl form-inline">

        <?= $form->field($model, 'year') ?>

        <?= $form->field($model, 'product') ?>

        <div class="form-group">
            <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
            <div class="help-block"></div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
