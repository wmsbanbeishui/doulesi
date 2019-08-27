<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\table\Level */

$this->title = 'Create Level';
$this->params['breadcrumbs'][] = ['label' => 'Levels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="level-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
