<?php

use admin\models\Admin;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model admin\models\search\AccountSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="account-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="pl form-inline">

        <?= $form->field($model, 'admin_id')->dropDownlist(Admin::map(), ['prompt' => '全部']) ?>

        <?= $form->field($model, 'title') ?>


        <div class="form-group">
            <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
            <div class="help-block"></div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
