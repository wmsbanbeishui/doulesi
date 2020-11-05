<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\table\Salary */

$this->title = '更新工资记录: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => '工资列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新工资';
?>
<div class="salary-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
