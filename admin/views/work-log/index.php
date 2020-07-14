<?php

use common\helpers\Render;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel admin\models\search\WorkLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '工作日志';
$this->params['breadcrumbs'][] = $this->title;

$grid_column = [
    'id',
    'date',
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
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{view}&nbsp;&nbsp;&nbsp;&nbsp;{update}',
    ],
];
?>
<div class="work-log-index">
    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加工作日志', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= Render::gridView([
        'dataProvider' => $dataProvider,
        'columns' => $grid_column,
        'export_columns' => $grid_column,
        'export' => [
            'filename' => 'finance'.date('Y-m-d'),
        ],
    ]); ?>
</div>
