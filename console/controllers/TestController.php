<?php

namespace console\controllers;

use common\models\table\WorkLog;
use Yii;
use yii\console\Controller;

class TestController extends Controller
{
    public function actionIndex()
    {
        echo 'hello world';
    }

    public function actionSwooleAdd()
    {
        $queryString = getopt('finish:');
        swoole_timer_after(1000, function () use($queryString) {
            $work = new WorkLog();
            $work->plan = '计划';
            $work->finish = $queryString['finish'];
            $work->date = date('Y-m-d');
            $work->save();
        });
    }
}