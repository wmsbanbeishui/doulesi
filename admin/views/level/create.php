<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\table\Level */

$this->title = '创建等级';
$this->params['breadcrumbs'][] = ['label' => '等级', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="level-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
