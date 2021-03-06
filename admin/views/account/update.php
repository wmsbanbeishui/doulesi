<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\table\Account */

$this->title = '更新账号: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => '账号列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="account-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
