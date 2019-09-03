<?php

use common\models\table\Category;
use common\services\LevelService;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\table\Category */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '类别', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="category-view">

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?= Html::a('添加分类', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
            	'attribute' => 'level',
				'value' => function ($model) {
    				return LevelService::getNameById($model->level);
				}
			],
			[
				'attribute' => 'status',
				'value' => function ($model) {
    				return Category::statusMap($model->status);
				}
			],
            'create_time',
            'update_time',
        ],
    ]) ?>

</div>
