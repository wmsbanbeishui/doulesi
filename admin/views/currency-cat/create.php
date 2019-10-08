<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\table\CurrencyCat */

$this->title = '创建类别';
$this->params['breadcrumbs'][] = ['label' => '类别', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="currency-cat-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
