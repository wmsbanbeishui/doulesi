<?php

use admin\models\Admin;
use common\helpers\JsBlock;
use common\models\table\Finance;
use common\models\table\Level;
use common\services\CategoryService;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\table\Finance */
/* @var $form yii\widgets\ActiveForm */

$cat_list = CategoryService::getCatByLevel($model->level_id);
?>

<div class="finance-form">

	<?php $form = ActiveForm::begin([
		'options' => [
			'class' => ['form-horizontal'],
		],
		'fieldConfig' => [
			'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
			'labelOptions' => ['class' => ['control-label', 'col-lg-1']],
		],
	]); ?>

	<?= $form->field($model, 'level_id')->dropDownList(Level::map(), ['prompt' => '请选择', 'id' => 'level'])?>

	<?= $form->field($model, 'cat_id')->dropDownList($cat_list, ['prompt' => '请选择', 'id' => 'category']) ?>

	<?= $form->field($model, 'admin_id')->dropDownList(Admin::map()) ?>

    <?= $form->field($model, 'cost')->textInput(['maxlength' => true]) ?>

	<div class="form-group">
		<label class="control-label col-lg-1">日期</label>
		<div class="col-lg-3">
			<?php echo DatePicker::widget([
				'name' => 'Finance[date]',
				'value' => $model->isNewRecord ? date('Y-m-d', strtotime('-1 day')) : $model->date,
				'options' => ['id' => 'FinanceDate', 'placeholder' => ''],
				'pluginOptions' => [
					'format' => 'yyyy-mm-dd',
					'todayHighlight' => true,
				],
			]); ?>
		</div>
		<div class="col-lg-8">
			<div class="help-block"></div>
		</div>
	</div>

    <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(Finance::statusMap()) ?>

    <div class="form-group">
		<div class="col-lg-offset-1 col-lg-11">
        	<?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
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
				obj.append("<option>请选择</option>");
			}

			$.each(data,function(i,e){
				obj.append("<option value='"+e.id+"'>"+e.name+"</option>");
			});
		}
	})
</script>
<?php JsBlock::end() ?>
