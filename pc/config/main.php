<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

$config = [
    'id' => 'app-pc',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'pc\controllers',
	'defaultRoute' => 'site',
	'params' => $params,
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-pc',
        ],
        'user' => [
            'identityClass' => 'common\models\table\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-pc', 'httpOnly' => true],
			'loginUrl' => 'login',
			'acceptableRedirectTypes' => ['*/*', 'text/html', 'application/xhtml+xml'],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the pc
            'name' => 'advanced-pc',
        ],
		'errorHandler' => [
			'errorAction' => 'site/error',
		],
		'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'rules' => require __DIR__ . '/route.php',
		],
		'authManager' => [
			'class' => 'yii\rbac\DbManager',
		],
		'assetManager' => [
			'bundles' => [
				'yii\web\JqueryAsset' => [
					'sourcePath' => null,
					'basePath' => '@webroot',
					'baseUrl' => '@web',
					'js' => [
						// 'js/jquery/2.2.4/jquery.min.js',
					],
				],
				'yii\bootstrap\BootstrapAsset' => [
					'sourcePath' => null,
					'basePath' => '@webroot',
					'baseUrl' => '@web',
					'css' => ['static/pc/css/bootstrap.min.css'],
				],
			]
		],
		'modules' => [
			'gridview' => [
				'class' => 'kartik\grid\Module',
			],
		],
    ],
];

if (YII_ENV_DEV) {
	// configuration adjustments for 'dev' environment
	$config['bootstrap'][] = 'debug';
	$config['modules']['debug'] = [
		'class' => 'yii\debug\Module',
		'allowedIPs' => ['*.*.*.*'],
	];
}

return $config;
