<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\table\Finance */

$this->title = '创建明细';
$this->params['breadcrumbs'][] = ['label' => '账单', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="finance-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
