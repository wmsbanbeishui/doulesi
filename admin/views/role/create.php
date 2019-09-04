<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model admin\models\Auth */

$this->title = '新增角色';
$this->params['breadcrumbs'][] = ['label' => '角色管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
