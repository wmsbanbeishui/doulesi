<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\table\Category */

$this->title = '更新类别: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => '类别', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="category-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
