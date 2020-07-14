<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'dJ_j1j6KXGlUdtJCyRD6NXdbeD_7V7jv',
        ],
    ],
];

if (YII_DEBUG) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'model' => [
                'class' => 'yii\gii\generators\model\Generator',
                'ns' => 'common\models\base',
                'baseClass' => 'common\extensions\ActiveRecord',
                'generateLabelsFromComments' => true,
                'useTablePrefix' => false,
            ],
            'crud' => [
                'class' => 'yii\gii\generators\crud\Generator',
                'modelClass' => 'common\models\table\(Model名)',
                'controllerClass' => 'admin\controllers\(控制器名)Controller',
                'viewPath' => '@admin/views/(路由)',
                'baseControllerClass' => 'admin\controllers\base\AuthController',
                'searchModelClass' => 'admin\models\search\(Model名)Search',
            ],
        ],
    ];
}
return $config;
