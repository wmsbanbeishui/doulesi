<?php

namespace common\services;

use common\helpers\Helper;
use common\models\table\WorkLog;
use Yii;

class TestService
{
    /**
     * 支付宝PC端支付
     * @throws \Exception
     */
    public static function aliPay()
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
            'body' => '逗乐思'
        ];

        $pay_data = json_encode($pay_data);
        $request->setBizContent($pay_data);
        $result = $aop->pageExecute($request);
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode = $result->$responseNode->code;
        if(!empty($resultCode)&&$resultCode == 10000){
            echo "成功";
        } else {
            echo "失败";
        }

        return $result;
        //die($result);
    }

    /**
     * 支付宝支付回调
     * @return string
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\log\LogRuntimeException
     */
    public static function aliPayNotify()
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

        return 'success'; // 不用加
    }

    /**
     * 支付宝当面扫码支付
     * @return array
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\log\LogRuntimeException
     */
    public static function aliPayCode()
    {
        header("Content-type: text/html; charset=utf-8");
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

            $http_server = Helper::get_request_host();
            $qr_code_url = $result->$responseNode->qr_code;

            $qr_code_url = $http_server.'/test/qrcode?data='.urlencode($qr_code_url);
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
}