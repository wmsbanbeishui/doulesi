<?php
namespace common\services;

use common\helpers\Helper;
use common\models\table\CodeMsg;
use common\validator\MobileValidator;
use Yii;

class CodeMsgService
{
    public static function sendCode($mobile)
    {
        $request = Yii::$app->getRequest();
        $ip = $request->getRemoteIP();
        $time = time();

        $mobileValidator = new MobileValidator();
        if (!$mobileValidator->validate($mobile)) {
            return [
                'code' => 101,
                'msg' => '手机号格式错误'
            ];
        }

        $code = rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9);

        $model = new CodeMsg();
        $model->type = 1;
        $model->mobile = $mobile;
        $model->code = $code;
        $model->from_ip = $ip;
        $model->deadline = $time + Helper::getParam('sms_code_wait_second');
        $model->create_time = $time;

        if (!$model->save()) {
            return [
                'code' => 102,
                'msg' => current($model->getFirstErrors())
            ];
        }

        // 阿里云发送
        $sms_tpl_code = 'SMS_205445421';
        $return = SmsService::sendSMS($mobile, '逗乐思', $sms_tpl_code, ['code' => $code]);
        //var_dump($return);exit;
        if (!isset($return['Message'])) {
            return [
                'code' => 103,
                'msg' => '发送失败，请稍后重试！'
            ];
        }

        if ($return['Message'] == 'OK') {
            $model->status = 1;
            $model->notify_time = date('Y-m-d H:i:s');
            $model->save();
            return [
                'code' => 0,
                'msg' => '发送成功'
            ];
        } else {
            return [
                'code' => 104,
                'msg' => '发送失败，请稍后重试！'
            ];
        }
    }
}