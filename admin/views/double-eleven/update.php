<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\table\DoubleEleven */

$this->title = '更新双十一: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => '双十一', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="double-eleven-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
