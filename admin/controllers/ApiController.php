<?php

namespace admin\controllers;

use admin\controllers\base\AuthController;
use common\models\table\ArticleSearch;
use common\models\table\Category;
use Yii;

class ApiController extends AuthController
{
    public function actionLevel()
    {
        Yii::$app->response->format = 'json';
        $level_id = Yii::$app->request->post('level_id');
        if ($level_id == null) {
            return ['code' => 0, 'data' => []];
        }
        $data = Category::find()
            ->select(['id', 'name'])
            ->where(['level' => $level_id])
            ->orderBy(['order_index' => SORT_DESC])
            ->all();
        return ['code' => 0, 'data' => $data];
    }

    public function actionSearch()
    {
        Yii::$app->response->format = 'json';
        $request = Yii::$app->request;
        $keyword = $request->get('keyword');

        //利用elasticsearch进行检索
        $searchModel = ArticleSearch::find()->query([
            'multi_match' => [
                'query' => $keyword,
                'fields' => ['title', 'description']
            ]
        ]);

        $data = $searchModel->highlight([
            "pre_tags" => ['<span class="hightlight">'],
            "post_tags" => ["</span>"],
            "fields" => [
                "title" => new \stdClass(),
                "description" => new \stdClass(),
            ]
        ])->asArray()->all();

       // var_dump($data);exit;


        return ['code' => 0, 'data' => $data];
    }
}
