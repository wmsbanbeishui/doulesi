<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\table\Currency */

$this->title = '新增币种';
$this->params['breadcrumbs'][] = ['label' => '币种列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="currency-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
