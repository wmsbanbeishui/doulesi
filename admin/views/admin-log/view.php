<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\table\AdminLog;

/* @var $this yii\web\View */
/* @var $model common\models\table\AdminLog */

$this->title = "查看{$model->id}";
$this->params['breadcrumbs'][] = ['label' => '管理员日志', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-log-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'admin_id',
            'menu_id',

            [
            'attribute'=>'action',
            'label'=>'操作',
            'captionOptions'=>['style'=>'width:120px;'],
            'value'=>AdminLog::actionMap($model->action),
            ],
            'content',
            'table',
            'field',
            'origin:ntext',
            'new:ntext',
            'create_time',
            'update_time',
        ],

        'template' =>  '<tr><th{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',

    ]) ?>

</div>
