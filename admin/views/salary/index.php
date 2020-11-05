<?php

use common\helpers\Render;
use common\services\AdminService;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel admin\models\search\SalarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '工资列表';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    'id',
    'date',
    [
        'attribute' => 'admin_id',
        'value' => function ($model) {
            return AdminService::getNameById($model->admin_id);
        }
    ],
    'salary',
    [
        'attribute' => 'remark',
        'value' => function ($model) {
            return $model->remark;
        },
        'contentOptions' => [
            'style' => 'white-space:normal;word-wrap:break-word;word-break:break-all;width:350px;text-align:left;padding-left:30px',
        ],
    ],
    'create_time',
    [
		'class' => 'yii\grid\ActionColumn',
		'template' => '{update} {delete}',
	],
];
?>
<div class="salary-index">
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加工资记录', ['create'], ['class' => 'btn btn-success']) ?>
        <span style="color:red; padding-left: 20px">总计：<?= $sum ?></span>
    </p>

    <?= Render::gridView([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'export_columns' => $gridColumns,
        'export' => [
            'filename' => 'salary'.date('Y-m-d'),
        ],
    ]); ?>
</div>
