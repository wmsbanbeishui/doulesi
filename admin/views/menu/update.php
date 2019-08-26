<?php

/* @var $this yii\web\View */
/* @var $model backend\models\Menu */

$this->title = '修改菜单: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '菜单管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="menu-base-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
