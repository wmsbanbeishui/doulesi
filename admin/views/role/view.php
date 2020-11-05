<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model admin\models\Auth */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Auths', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-view">

    <p>
        <?= Html::a('修改角色', ['update', 'id' => $model->name], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除角色', ['delete', 'id' => $model->name], [
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
			'name',
			'description',
			[
				'label' => '角色用户',
				'format' => 'raw',
				'value' => function ($model) {
					$admin_str = '';
					foreach ($model['authAdmin'] as $admin) {
						$admin_str .= Html::a($admin['realname'], ['/admin/set-roles', 'id' => $admin['id']]) . ',';
					}
					return trim($admin_str, ',');
				},
			]
		],
	]) ?>

</div>
