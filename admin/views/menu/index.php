<?php

use admin\models\AdminMenu;
use common\helpers\JsBlock;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '菜单管理';
$this->params['breadcrumbs'][] = $this->title;
$gridColumns = [
	'id',
	'name',
	[
		'attribute' => 'pid',
		'value' => function ($model) {
			return AdminMenu::getMenuMap($model->pid);
		},
	],
	//'uri',
	[
		'attribute' => 'uri',
		'format' => 'raw',
		'value' => function ($model) {
			if (!empty($model->uri) && $model->uri != '#') {
				return Html::a($model->uri, $model->uri, []);
			}
		},
	],
	'description',
	[
		'attribute' => 'status',
		'value' => function ($model) {
			return AdminMenu::statusMap($model->status);
		},
	],

	[
		'class' => 'yii\grid\ActionColumn',
		'template' => '{update}',
	],

	[
		'header' => '子菜单',
		'format' => 'raw',
		'value' => function ($model) {
			$str = Html::a('查看子菜单', ['index', 'AdminMenu[pid]' => $model->id], ['class' => 'btn btn-xs btn-warning']).' '
				.Html::a('添加子菜单', ['create', 'pid' => $model->id], ['class' => 'btn btn-xs btn-warning']);
			return $str;
		},
	],
	 'icon',
	'order_index',
];
?>
<style type="text/css">
	th,td{text-align: center;}
</style>
<div class="menu-base-index" style="width: 1000px;">
	<?= $this->render('_search', ['model' => $searchModel]); ?>
	<div id="info" style="padding: 15px 0;line-height: 200%;"> </div>
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => $gridColumns,
	]); ?>
</div>

<?php JsBlock::begin() ?>
<script type="text/javascript">
$(function(){
	$("#copy").click(function(){
		if(!confirm('是否copy正式数据表中的菜单及权限？会增加服务器负担，请勿频繁操作。')){
			return ;
		}

		$.ajax({
			url:'/menu-copy/doing',
			dataType:'json',
			beforeSend:function(){
				$("#info").html('处理中……')
			},
			success:function(e){
				if(e.code==0){
					str = '处理影响数据量如下：<br/>';
					str +='菜单表 复制 ' + e.data.m.copy_data + ' ;<br/>';
					str +='权限菜单对应表 复制'+ e.data.am.copy_data + ' ; <br/>';
					str += '角色及权限表 添加'+ e.data.ai.a+ ' ;<br/>';
					str += '角色及权限对应表 添加' + e.data.aic.a + ' 。';
					$("#info").html(str);
				}
			}
		})
	})
})
</script>
<?php JsBlock::end() ?>

