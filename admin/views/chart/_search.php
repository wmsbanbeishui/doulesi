<?php

use common\helpers\JsBlock;
use common\services\CategoryService;
use common\widgets\DateRangePicker;
use admin\models\Admin;
use common\models\table\Level;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model admin\models\search\FinanceSearch */
/* @var $form yii\widgets\ActiveForm */

$cat_list = CategoryService::getCatByLevel($model->level_id);

$type_list = ['1' => '等级', '2' => '月份'];
?>

<div class="finance-search">

	<?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',
	]); ?>

	<div class="pl form-inline">

		<?= $form->field($model, 'admin_id')->dropDownList(Admin::map(), ['prompt' => '全部']) ?>

		<?= $form->field($model, 'level_id')->dropDownList(Level::map(), ['prompt' => '请选择', 'id' => 'level'])?>

		<?= $form->field($model, 'cat_id')->dropDownList($cat_list, ['prompt' => '请选择', 'id' => 'category']) ?>

		<?= $form->field($model, 'type')->dropDownList($type_list, ['id' => 'type'])->label('类型') ?>

		<?= $form->field($model, 'date')->widget(DateRangePicker::className()) ?>

		<div class="form-group">
			<?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
			<?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
			<div class="help-block"></div>
		</div>
	</div>

	<?php ActiveForm::end(); ?>

</div>

<?php JsBlock::begin() ?>
<script type="text/javascript">
	$(function(){
		$("#level").change(function () {
			var level_id = $(this).val();
			var obj = $("#category");
			$.ajax({
				url: '/api/level',
				type: 'post',
				data: {level_id: level_id},
				success: function (e) {
					reset(obj, e.data, 1);
				}
			})
		})

		function reset(obj,data,prompt){
			obj.empty();
			if(prompt){
				obj.append("<option value>请选择</option>");
			}

			$.each(data,function(i,e){
				obj.append("<option value='"+e.id+"'>"+e.name+"</option>");
			});
		}
	})
</script>
<?php JsBlock::end() ?>

