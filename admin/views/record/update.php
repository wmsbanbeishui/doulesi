<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\table\Record */

$this->title = '更新记事: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => '记事列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="record-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
