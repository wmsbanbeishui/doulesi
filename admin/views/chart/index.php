<?php

use Hisune\EchartsPHP\ECharts;

/* @var $this yii\web\View */
/* @var $searchModel admin\models\search\FinanceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '等级图表';
$this->params['breadcrumbs'][] = $this->title;

$chart = new ECharts();
$chart->title->text = $type == 2 ? '月份费用' : '等级费用';
$chart->title->left= 'center';
$chart->tooltip->show = true;
$chart->legend->data[] = '总金额';
$chart->legend->left= 'right';
$chart->xAxis[] = array(
	'type' => 'category',
	'data' => $name
);
$chart->yAxis[] = array(
	'type' => 'value'
);
$chart->series[] = array(
	'name' => '总金额',
	'type' => 'bar',
	'data' => $cost

);

?>
<div class="finance-index">
	<?php echo $this->render('_search', ['model' => $searchModel]); ?>

	<p>
		<span style="color:red; padding-left: 20px">总计：<?= $sum_cost ?></span>
	</p>

	<div id="chart1">
		<?php echo $chart->render('simple-custom-1'); ?>
	</div>
</div>
