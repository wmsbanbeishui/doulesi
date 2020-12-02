<?php

namespace admin\controllers;

use admin\models\form\TestImportForm;
use admin\controllers\base\ApiController;
use common\helpers\Helper;
use common\services\TestService;
use yii\helpers\FileHelper;
use Yii;

class TestController extends ApiController
{
    protected static function authAction()
    {
        return [];
    }

    protected static function normalAction()
    {
        return ['ali-pay', 'ali-pay-notify', 'ali-pay-code', 'qrcode', 'test'];
    }

    /**
     * 打印 phpinfo信息
     */
    public function actionIndex()
    {
        echo phpinfo();
        echo '333';
        //return $this->render('index');
    }

    /**
     * 测试导入
     * @return string|\yii\web\Response
     */
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

    /**
     * 下载文件
     * @return \yii\console\Response|\yii\web\Response
     */
    public function actionImportTemplate()
    {
        $response = Yii::$app->getResponse();
        return $response->sendFile(Yii::getAlias('@webroot/import_template.xlsx'));
    }

    /**
     * 支付宝PC端支付
     * @throws \Exception
     */
    public function actionAliPay()
    {
        return TestService::aliPay();
    }

    /**
     * 支付宝支付回调
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\log\LogRuntimeException
     */
    public function actionAliPayNotify()
    {
        return TestService::aliPayNotify();
    }

    /**
     * 支付宝当面扫码支付
     * @return array
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\log\LogRuntimeException
     */
    public function actionAliPayCode()
    {
        return TestService::aliPayCode();
    }

    /**
     * 生成支付二维码图片
     */
    public function actionQrcode() {
        $request = Yii::$app->request;
        $data = $request->get('data');
        Helper::fLogs($data, 'qrcode.log');

        require_once Yii::getAlias('@common/phpqrcode/phpqrcode.php');

        \QRcode::png($request->get('data'), false, $level = QR_ECLEVEL_L, $size = 5, $margin = 4);
        exit(0);
    }

    public function actionTest()
    {
        $request = Yii::$app->getRequest();
        $url = $request->post('url'); // 更新时的url
        $fname = $request->post('fname');
        $cid = $request->post('cid');

        $key = '';

        if (isset($_FILES['file']['name'])) {

            $path_parts = pathinfo($url);
            $path = $path_parts['dirname'];
            $upload = \common\helpers\FileHelper::fileUpload($_FILES['file'], $path, 1024 * 1024);

            if ($upload['errno'] == 0) {
                $key = $upload['key'];
            } else {
                return [
                    'code' => 102,
                    'msg' => $upload['msg']
                ];
            }
        } else {
            return [
                'code' => 103,
                'msg' => '请上传图片'
            ];
        }

        if (empty($key)) {
            return [
                'code' => 104,
                'msg' => '请上传文件'
            ];
        }

        return [
            'code' => 0,
            'msg' => '',
            'data' => [
                'url' => $key,
                //'full_url' => Helper::getImageUrl($key)
            ]
        ];
    }
}
