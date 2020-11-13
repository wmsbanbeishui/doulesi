<?php

namespace admin\controllers;

use admin\models\form\TestImportForm;
use admin\controllers\base\ApiController;
use common\helpers\Helper;
use common\models\table\CodeMsg;
use common\models\table\WorkLog;
use Yii;

class TestController extends ApiController
{
    protected static function authAction()
    {
        return [];
    }

    protected static function normalAction()
    {
        return ['ali-pay', 'ali-pay-notify', 'ali-pay-code'];
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
            'total_amount' => '0.01',
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
        require_once Yii::getAlias('@common/alipay/pcweb/pagepay/service/AlipayTradeService.php');

        $data = Yii::$app->request->post();
        Helper::fLogs($data, 'alipay_notify.log');

        $config = Helper::getParam('alipay');
        $service_obj = new \AlipayTradeService($config);
        $result = $service_obj->check($data);
        Helper::fLogs($result, 'alipay_notify.log');

        if ($result) {
            if ($data['trade_status'] === 'TRADE_SUCCESS') {
                $model = new WorkLog();
                $model->plan = '支付宝支付回调';
                $model->finish = '支付宝PC端支付';
                $model->date = date('Y-m-d H:i:s');
                $model->save();

                echo 'success';
            }
        } else {
            echo '非法操作';
        }

    }

    public function actionAliPayCode()
    {
        header("Content-type: text/html; charset=utf-8");
        require_once Yii::getAlias('@common/phpqrcode/phpqrcode.php');
        require_once Yii::getAlias('@common/alipay/pcweb/aop/request/AlipayTradePrecreateRequest.php');
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

        $request = new \AlipayTradePrecreateRequest();
        $request->setNotifyUrl($config['notify_url']);
        $request->setReturnUrl($config['return_url']);

        $pay_data = [
            'out_trade_no' => Helper::gen_order_no(),
            'product_code' => 'FACE_TO_FACE_PAYMENT',
            'total_amount' => '0.01',
            'subject' => '逗乐思',
            'body' => '特蓝图',
            'timeout_express' => '5m',  //过期时间
        ];

        $pay_data = json_encode($pay_data);
        $request->setBizContent($pay_data);
        $result = $aop->execute($request);
        Helper::fLogs($result, 'alipay_code.log');

        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode = $result->$responseNode->code;
        if(!empty($resultCode) && $resultCode == 10000){

            $qr_code_url = $result->$responseNode->qr_code;

            $qr_code_url = \QRcode::png($qr_code_url);
            return [
                'code' => 0,
                'msg' => '',
                'data' => [
                    'qr_code_url' => $qr_code_url
                ]
            ];

        } else {
            return [
                'code' => 101,
                'msg' => '支付失败',
            ];
        }
    }

    /**
     * 生成支付二维码图片
     */
    public function actionQrcode() {
        $request = Yii::$app->request;

        require_once Yii::getAlias('@common/phpqrcode/phpqrcode.php');

        \QRcode::png($request->get('data'));
        exit(0);
    }
}
