<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\table\Chowmatistic */

$this->title = '更新交易: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => '交易列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="chowmatistic-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
