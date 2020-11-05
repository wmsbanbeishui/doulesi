<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\table\WorkLog */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '日志列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-log-view">

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'plan',
                'format' => 'raw',
                'value' => function ($models) {
                    return $models->plan;
                }
            ],
            [
                'attribute' => 'finish',
                'format' => 'raw',
                'value' => function ($models) {
                    return $models->finish;
                }
            ],
            'date',
            'create_time',
            'update_time',
        ],
    ]) ?>

</div>
