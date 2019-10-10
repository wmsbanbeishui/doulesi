<?php

$config = [
	'components' => [
		'mailer' => [
			'class' => 'yii\swiftmailer\Mailer',
			'useFileTransport' =>false,
			'transport' => [
				'class' => 'Swift_SmtpTransport',
				'host' => 'smtp.qq.com',  //每种邮箱的host配置不一样
				'username' => '269243737@qq.com',
				'password' => 'mpecljnkiuwybgde',
				'port' => '465',
				'encryption' => 'ssl',

			],
			'messageConfig'=>[
				'charset'=>'UTF-8',
				'from'=>['269243737@qq.com'=>'逗乐思']
			],
		],
	]
];

return $config;
