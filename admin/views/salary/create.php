<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\table\Salary */

$this->title = '添加工资';
$this->params['breadcrumbs'][] = ['label' => '工资列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="salary-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
