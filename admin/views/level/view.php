<?php

use common\models\table\Level;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\table\Level */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '等级', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="level-view">

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?= Html::a('添加等级', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
				'attribute' => 'status',
				'value' => function ($model) {
					return Level::statusMap($model->status);
				},
			],
            'create_time',
            'update_time',
        ],
    ]) ?>

</div>
