<?php

use admin\models\Admin;
use common\models\base\AuthAssignment;
use common\models\table\Station;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\base\BaikeBase */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => '管理员', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="baike-base-view">
	<?= DetailView::widget([
		'model' => $model,
		'attributes' => [
			'id',
			'username',
			'realname',
			'mobile',
			'email',
			[
				'attribute' => 'status',
				'label' => '状态',
				'value' => function ($model) {
					return Admin::statusMap($model->status);
				},
			],
			[
				'format' => 'raw',
				'label' => '拥有角色',
				'value' => function ($model) {
					$auth_str = '';
					$auths_list = AuthAssignment::find()->select(['i.description', 'item_name'])->joinWith(['itemName i'])->where(['user_id' => $model->id])->asArray()->all();
					if (empty($auths_list)) {
						return null;
					} else {
						foreach ($auths_list as $key => $auth) {
							$auth_str .= Html::a($auth['description'], ['/role/list', 'role' => $auth['item_name']]) . ',';
						}
						return trim($auth_str, ',');
					}
				},
			],
			[
				'attribute' => 'station_id',
				'label' => '分站',
				'value' => function ($model) {
					return Station::stationMap($model->station_id);
				},
			],
			'create_time',
			'update_time',
			'pwd_expired'
		],
		'template' => '<tr><td width="100">{label}</td><td{contentOptions}>{value}</td></tr>',

	]) ?>

	<p>
		<?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?= Html::a('删除', ['delete', 'id' => $model->id], [
			'class' => 'btn btn-danger',
			'data' => [
				'confirm' => 'Are you sure you want to delete this item?',
				'method' => 'post',
			],
		]) ?>
	</p>

</div>
