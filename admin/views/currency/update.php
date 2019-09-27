<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\table\Currency */

$this->title = '更新币种: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => '币种列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="currency-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
