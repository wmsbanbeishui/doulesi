<?php

$components = [
	'formatter' => [
		// 'nullDisplay' => '',
		'defaultTimeZone' => 'Asia/Shanghai',
		'dateFormat' => 'php:Y-m-d',
		'datetimeFormat' => 'php:Y-m-d H:i:s',
		'timeFormat' => 'php:H:i:s',
	],
	'cache' => [
		'class' => 'yii\redis\Cache',
		'redis' => 'redis',
		'keyPrefix' => 'yii_',
	],
	'log' => [
		'traceLevel' => YII_DEBUG ? 3 : 0,
		'targets' => [
			[
				'class' => 'common\helpers\FileTarget',
				'levels' => ['error', 'warning'],
			],		],
	],
];

$components = array_merge(
	$components,
	require(__DIR__.'/db.php')
);

$db_local = __DIR__.'/db-local.php';
if (file_exists($db_local)) {
	$components = array_merge(
		$components,
		require($db_local)
	);
}

$config = [
	'id' => 'doulesi',
	'name' => '逗乐思',
	'vendorPath' => dirname(dirname(__DIR__)).'/vendor',
	'language' => 'zh-CN',
	'timeZone' => 'Asia/Shanghai',
	'components' => $components,
	'aliases' => [
		'@bower' => '@vendor/bower-asset',
		'@npm' => '@vendor/npm-asset',
	],
];

return $config;
