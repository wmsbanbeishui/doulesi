<?php
/*// 获取参数，第一为控制器，第二个为方法，第0个为调用的文件路径
// var_dump($argv);
// exit;
$c = $argv[1];
$a = $argv[2];
//拼出类文件路径, 如果a为index crontab_path = index.controller.php
$crontab_path = 'controller/' . $c . '.controller.php';
//引入该文件
require $crontab_path;
//实例化类
$controller = new $c;
//调用该方法
$controller->$a();*/

/*echo '111'.PHP_EOL;
swoole_timer_after(5000, function () {
    echo '222'.PHP_EOL;
});
echo '333'.PHP_EOL;*/

use common\models\table\WorkLog;

$queryString['finish'] = '已完成123';
swoole_timer_after(10000, function () use($queryString) {
    $work = new WorkLog();
    $work->plan = '计划';
    $work->finish = $queryString['finish'];
    $work->date = date('Y-m-d');
    $work->save();
});
