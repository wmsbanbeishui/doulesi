<?php

namespace admin\controllers\base;

use common\helpers\Helper;
use yii\web\Response;
use yii\rest\Controller;
use yii\filters\ContentNegotiator;
use yii\filters\auth\QueryParamAuth;

/**
 * API基础控制器
 */
class ApiController extends Controller
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        Helper::set_cors();
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'contentNegotiator' => [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ]
            ],
            'authenticator' => [
                'class' => QueryParamAuth::className(),
            ]
        ]);
    }
}
