<?php

/* @var $this yii\web\View */
/* @var $model backend\models\Menu */

$this->title = '新增菜单';
$this->params['breadcrumbs'][] = ['label' => '菜单管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$model->order_index = 0;
?>

<div class="menu-base-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

