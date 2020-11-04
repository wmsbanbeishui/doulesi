<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,



	// 开启发送错误到邮箱 0-关闭；1-开启；
	'send_error_report' => 1,
	// 错误报告邮箱接收人
	'error_report_receiver' =>  [
		'773728950@qq.com' => ['admin'],
		'269243737@qq.com' => ['admin'],
	],

	// 汇率
	'exchange_rate' => 7,

    // 阿里云存储配置
    'ali_oss_ak' => 'OK_qgQW3ojWLsyHsH5yG',
    'ali_oss_sk' => 'XkNNgwgAnzSgQohuxfVy',
    // 私有图片bucket
    'ali_private_bucket' => 'drhs-test-private',
    // 公开图片bucket
    'ali_public' => 'drhs-test-public',



    // 七牛存储配置
    'qiniu_ak' => 'OK_qgQW3ojWLsyHsH5yG_jqzjaXaxcaDY2E2IbFs',
    'qiniu_sk' => 'XkNNgwgAnzSgQohuxfVy_J9XXFliMn_Keeehiaz9',
    // 私有图片bucket
    'qiniu_priv_bucket' => 'cdd-test-priv',
    // 公开图片bucket
    'qiniu_pub_bucket' => 'cdd-test-pub',
    // 私有图片域名
    'qiniu_priv_host' => 'priv.cdn.test.chedidi.com',
    // 公开图片域名
    'qiniu_pub_host' => 'gz.cdn.test.chedidi.com',
    // 共享图片域名,正式测试共用
    'qiniu_share_host' => 'gz.cdn.chedidi.com',
];
