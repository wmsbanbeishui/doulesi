<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\table\WorkLog */

$this->title = '添加工作日志';
$this->params['breadcrumbs'][] = ['label' => '日志列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-log-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
