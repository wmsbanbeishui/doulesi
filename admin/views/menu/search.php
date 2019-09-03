<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Menu;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '菜单搜索';
$this->params['breadcrumbs'][] = $this->title;
$gridColumns = [
    //['class' => SerialColumn::className()],

    'name',
    [
        'attribute' => 'uri',
        'format'=>'raw',
        'value' => function ($model) {
            if(!empty($model->uri) && $model->uri!='#'){
                return Html::a($model->uri,$model->uri,[]);
            }
        },
    ],
    'description',
];

if(Yii::$app->user->id==1){
    array_push($gridColumns , [
        'header'=>'管理',
        'class' => 'yii\grid\ActionColumn',
        'template' => '{update} {delete}',
    ]);
}
?>
<style type="text/css">
    th,td{text-align: center;}
</style>
<div class="menu-base-index" style="width: 1000px;">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
    ]); ?>
</div>
