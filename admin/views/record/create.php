<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\table\Record */

$this->title = '新增记事';
$this->params['breadcrumbs'][] = ['label' => '记事列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="record-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
