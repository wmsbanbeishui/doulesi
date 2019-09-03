<?php

$config = [
    'db' => [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=127.0.0.1;dbname=doulesi',
        'username' => 'root',
		'password' => '123456',
        'charset' => 'utf8',

        // 表结构缓存
        'enableSchemaCache' => false,
        'schemaCacheDuration' => 3600,
        'schemaCache' => 'cache',

        // 查询缓存
        'enableQueryCache' => false,
        'queryCacheDuration' => 3600,
        'queryCache' => 'cache',
    ],
    'redis' => [
        'class' => 'yii\redis\Connection',
        'hostname' => '127.0.0.1',
        'port' => 6379,
        'database' => 0,
    ],
	'mongodb' => [
		'class' => 'yii\mongodb\Connection',
		'dsn' => 'mongodb://username:password@host:27017/admin',
	],
];

return $config;
