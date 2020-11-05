<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\table\WorkLog */

$this->title = '更新工作日志: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => '日志列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="work-log-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
