<?php

use common\helpers\Render;
use common\models\table\Impulse;
use common\services\AdminService;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel admin\models\search\ImpulseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '冲动消费列表';
$this->params['breadcrumbs'][] = $this->title;

$grid_columns = [
    'id',
    'date',
    [
        'attribute' => 'admin_id',
        'value' => function ($model) {
            return AdminService::getNameById($model->admin_id);
        }
    ],
    [
        'attribute' => 'type',
        'value' => function ($model) {
            return Impulse::typeMap($model->type);
        }
    ],
    'amount',
    'create_time',
    [
        'attribute' => 'remark',
        'value' => function ($model) {
            return $model->remark;
        },
        'contentOptions' => [
            'style' => 'white-space:normal;word-wrap:break-word;word-break:break-all;width:350px;text-align:left;padding-left:30px',
        ],
    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{update} {delete}',
    ],
];
?>
<div class="impulse-index">
    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加', ['create'], ['class' => 'btn btn-success']) ?>
        <span style="color:red; padding-left: 20px">总计：<?= $sum_amount ?></span>
    </p>

    <?= Render::gridView([
        'dataProvider' => $dataProvider,
        'columns' => $grid_columns,
    ]); ?>
</div>
