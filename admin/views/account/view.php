<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\services\AdminService;


/* @var $this yii\web\View */
/* @var $model common\models\table\Account */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '账号列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-view">

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
            'url:url',
            'admin_id',
            'order_index',
            'create_at',
            'update_at',
        ],
    ]) ?>

</div>
