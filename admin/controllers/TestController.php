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
        $finish = '已完成123';
        echo '111'.PHP_EOL;
        //pclose(popen('php cli2cgi.php &', 'r'));
        system("php ./cli2cgi.php &", $phpResult);
        echo $phpResult.PHP_EOL;
        echo '222'.PHP_EOL;
    }
}
