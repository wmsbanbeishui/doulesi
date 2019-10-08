<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\table\CurrencyCat */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '类别', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="currency-cat-view">

	<p>
		<?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?= Html::a('添加分类', ['create'], ['class' => 'btn btn-success']) ?>
	</p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'order_index',
            'create_time',
            'update_time',
        ],
    ]) ?>

</div>
