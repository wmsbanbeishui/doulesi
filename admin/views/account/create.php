<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\table\Account */

$this->title = '添加账号';
$this->params['breadcrumbs'][] = ['label' => '账号列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
