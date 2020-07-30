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
        echo phpinfo();
        echo '333';
        //return $this->render('index');
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
        error_reporting(E_ALL);
        $finish = '已完成123';
        echo '111'.PHP_EOL;
        $handle = popen('php cli2cgi.php &', 'r');
        echo "'$handle';".gettype($handle)."\n";
        $read = fread($handle, 2096);
        echo $read;
        pclose($handle);
        //pclose(popen('php cli2cgi.php &', 'r'));
        echo '222'.PHP_EOL;
    }
}
