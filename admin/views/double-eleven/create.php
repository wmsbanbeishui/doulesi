<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\table\DoubleEleven */

$this->title = '添加';
$this->params['breadcrumbs'][] = ['label' => '添加', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="double-eleven-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
