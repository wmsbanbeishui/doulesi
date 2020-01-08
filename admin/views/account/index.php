<?php

use yii\helpers\Html;
use common\helpers\Render;
use common\services\AdminService;

/* @var $this yii\web\View */
/* @var $searchModel admin\models\search\AccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '账号列表';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    'id',
    [
        'attribute' => 'admin_id',
        'value' => function ($model) {
            return AdminService::getNameById($model->admin_id);
        }
    ],
    'title',
    'account',
    'password',
    //'url',
    'order_index',
    'create_at',
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{view} {update} {delete}',
    ],
];
?>
<div class="account-index">

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加账号', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= Render::gridView([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
    ]); ?>
</div>
