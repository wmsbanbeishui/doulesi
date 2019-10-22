<?php

use common\models\table\Currency;
use Hisune\EchartsPHP\ECharts;

/* @var $this yii\web\View */
/* @var $searchModel admin\models\search\FinanceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '等级图表';
$this->params['breadcrumbs'][] = $this->title;

$eos_sum = 0;
$eos_time = [];
$eos_profit = [];

$xrp_sum = 0;
$xrp_time = [];
$xrp_profit = [];

foreach ($data as $key => $value) {
	if ($value['cur_id'] == 3) { //EOS
		$eos_time[] = $value['offset_time'];
		$current_profit = round($value['profit'] - $value['commission'], 6);
		$eos_sum = $eos_sum + $current_profit;
		$eos_profit[] = $eos_sum;
	} elseif ($value['cur_id'] == 4) { //XRP
		$xrp_time[] = $value['offset_time'];
		$current_profit = round($value['profit'] - $value['commission'], 6);
		$xrp_sum = $xrp_sum + $current_profit;
		$xrp_profit[] = $xrp_sum;
	}
}

$eos_chart = new ECharts();
$eos_chart->title->text = '理财数据统计';
$eos_chart->title->left = 'center';
$eos_chart->title->top = '-4px';
$eos_chart->tooltip->show = true;
$eos_chart->legend->data[] = 'EOS';
$eos_chart->legend->top = '25px';
$eos_chart->xAxis[] = array(
	'type' => 'category',
	'data' => $eos_time
);
$eos_chart->yAxis[] = array(
	'type' => 'value'
);
$eos_chart->series[] = array(
	'name' => 'EOS',
	'type' => 'line',
	'stack' => '利润',
	'data' => $eos_profit

);


$xrp_chart = new ECharts();
$xrp_chart->title->text = '理财数据统计';
$xrp_chart->title->left = 'center';
$xrp_chart->title->top = '-4px';
$xrp_chart->tooltip->show = true;
$xrp_chart->legend->data[] = 'XRP';
$xrp_chart->legend->top = '25px';
$xrp_chart->xAxis[] = array(
	'type' => 'category',
	'data' => $xrp_time
);
$xrp_chart->yAxis[] = array(
	'type' => 'value'
);
$xrp_chart->series[] = array(
	'name' => 'XRP',
	'type' => 'line',
	'stack' => '利润',
	'data' => $xrp_profit

);

?>

<div class="finance-index">
	<?php echo $this->render('chart_search', ['model' => $searchModel]); ?>

	<div id="chart1">
		<span style="padding-left:100px; color:red;">EOS总和：<?= $eos_sum?></span>
		<?php echo $eos_chart->render('simple-custom-1'); ?>
	</div>

	<div id="chart2">
		<span style="padding-left:100px; color:red;">XRP总和：<?= $xrp_sum?></span>
		<?php echo $xrp_chart->render('simple-custom-2'); ?>
	</div>

</div>
