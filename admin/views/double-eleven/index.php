<?php

use common\helpers\Render;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel admin\models\search\DoubleElevenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '双十一';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    'id',
    'year',
    'product',
    'create_time',
    'update_time',
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{update} {delete}',
    ],
];

?>
<div class="double-eleven-index">

    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加', ['create'], ['class' => 'btn btn-success']) ?>
        <span style="color:red; padding-left: 20px">总计：<?= $sum_price ?></span>
    </p>

    <?= Render::gridView([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'export_columns' => $gridColumns,
        'export' => [
            'filename' => 'finance'.date('Y-m-d'),
        ],
    ]); ?>
</div>
