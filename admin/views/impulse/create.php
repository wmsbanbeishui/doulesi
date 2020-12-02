<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\table\Impulse */

$this->title = '添加';
$this->params['breadcrumbs'][] = ['label' => '冲动消费列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="impulse-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
