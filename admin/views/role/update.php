<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model admin\models\Auth */

$this->title = '修改角色: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => '角色管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="auth-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
