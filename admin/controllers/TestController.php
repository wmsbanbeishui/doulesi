<?php

namespace admin\controllers;

use admin\models\form\TestImportForm;
use admin\controllers\base\BaseController;
use common\models\table\WorkLog;
use Yii;

class TestController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionImport()
    {
        $request = Yii::$app->getRequest();

        $form = new TestImportForm();

        if ($request->getIsPost()) {
            if ($form->import()) {
                return $this->redirect('index');
            }
        } else {
            return $this->render('import', ['model' => $form]);
        }
    }

    public function actionImportTemplate()
    {
        $response = Yii::$app->getResponse();
        return $response->sendFile(Yii::getAlias('@webroot/import_template.xlsx'));
    }

    public function actionTest()
    {
        self::swooleAdd();
        echo '111';
    }

    public function swooleAdd()
    {
        swoole_timer_after(1000, function () {
            $work = new WorkLog();
            $work->plan = '计划';
            $work->finish = '完成';
            $work->date = date('Y-m-d');
            $work->save();
        });
    }
}
