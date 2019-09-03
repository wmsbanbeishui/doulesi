<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\table\Finance */

$this->title = '更新明细: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => '明细', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="finance-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
