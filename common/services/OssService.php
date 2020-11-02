<?php

namespace common\aliyun;

use common\helpers\Helper;
use OSS\OssClient;
use OSS\Croe\OssException;
use Yii;

class OssService
{
    public static function upload($file, $key, $private = false) {
        $auth = new Auth(Helper::getParam('qiniu_ak'), Helper::getParam('qiniu_sk'));

        $private_bucket = Helper::getParam('qiniu_priv_bucket');
        $public_bucket = Helper::getParam('qiniu_pub_bucket');
        $bucket = $private ? $private_bucket : $public_bucket;

        $expires = 3600;
        $policy = [
            'returnBody' => '{"key":"$(key)","fsize":$(fsize)}',
        ];
        $upToken = $auth->uploadToken($bucket, null, $expires, $policy, true);

        $uploadMgr = new UploadManager();
        if (!file_exists($file)) {
            return ['error' => 'file not exists'];
        }

        list($ret, $err) = $uploadMgr->putFile($upToken, $key, $file);
        if ($err !== null) {
            $message = $err->message();
            return false;
        } else {
            return true;
        }
    }
}
