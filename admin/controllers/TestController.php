<?php

namespace admin\controllers;

use admin\models\form\TestImportForm;
use admin\controllers\base\ApiController;
use common\helpers\Helper;
use common\models\table\CodeMsg;
use Yii;

class TestController extends ApiController
{
    protected static function authAction()
    {
        return [];
    }

    protected static function normalAction()
    {
        return ['ali-pay', 'ali-pay-notify'];
    }

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
        $finish = '已完成123';
        pclose(popen('php cli2cgi.php &', 'r'));
        echo 'aaa'.PHP_EOL;
    }

    public function actionAliPay()
    {
        header("Content-type: text/html; charset=utf-8");
        require_once Yii::getAlias('@common/alipay/pcweb/aop/request/AlipayTradePagePayRequest.php');
        require_once Yii::getAlias('@common/alipay/pcweb/aop/AopClient.php');
        $config = Helper::getParam('alipay');

        $aop = new \AopClient();
        $aop->gatewayUrl = $config['gatewayUrl'];
        $aop->appId = $config['app_id'];
        $aop->rsaPrivateKey = $config['merchant_private_key'];
        $aop->alipayrsaPublicKey = $config['alipay_public_key'];
        $aop->signType = $config['sign_type'];
        $aop->apiVersion = '1.0';
        $aop->format='json';
        $aop->postCharset = 'UTF-8';

        $request = new \AlipayTradePagePayRequest();
        $request->setNotifyUrl($config['notify_url']);
        $request->setReturnUrl($config['return_url']);

        $pay_data = [
            'out_trade_no' => Helper::gen_order_no(),
            'product_code' => $config['product_code'],
            'total_amount' => '2',
            'subject' => '逗乐思',
            'body' => '特蓝图'
        ];

        $pay_data = json_encode($pay_data);
        $request->setBizContent($pay_data);
        $result = $aop->pageExecute($request);
        die($result);
    }

    public function actionAliPayNotify()
    {
        Helper::fLogs('333', 'alipay_notify.log');
        $data = Yii::$app->request->post();
        $config = Helper::getParam('alipay');
        $service_obj = new \AlipayTradeService($config);
        $result = $service_obj->check($data);
        Helper::fLogs($result, 'alipay_notify.log');

        if ($result) {
            if ($data['trade_status'] === 'TRADE_SUCCESS') {
                $model = new CodeMsg();
                $model->mobile = '17322350852';
                $model->code = '2222';
                $model->type = 3;
                $model->deadline = time() + 120;
                $model->save();

                echo 'success';
            }
        } else {
            echo '非法操作';
        }

    }
}
