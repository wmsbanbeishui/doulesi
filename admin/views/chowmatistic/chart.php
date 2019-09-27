<?php

use Hisune\EchartsPHP\ECharts;

/* @var $this yii\web\View */
/* @var $searchModel admin\models\search\FinanceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '等级图表';
$this->params['breadcrumbs'][] = $this->title;

$chart = new ECharts();
$chart->title->text = '币种净利润';
$chart->title->left= 'center';
$chart->tooltip->show = true;
$chart->legend->data[] = '净利润';
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
	'data' => $net_profits

);

?>
<div class="finance-index">
	<?php echo $this->render('chart_search', ['model' => $searchModel]); ?>

	<div id="chart1">
		<?php echo $chart->render('simple-custom-1'); ?>
	</div>
</div>
