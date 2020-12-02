<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\table\Impulse */

$this->title = '更新: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => '冲动消费列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="impulse-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
