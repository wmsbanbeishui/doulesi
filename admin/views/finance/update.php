<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\table\Finance */

$this->title = 'Update Finance: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Finances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="finance-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
