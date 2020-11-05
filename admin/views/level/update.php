<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\table\Level */

$this->title = '更新等级: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => '等级', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="level-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
