<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\table\Chowmatistic */

$this->title = '新增交易';
$this->params['breadcrumbs'][] = ['label' => '交易列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chowmatistic-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
