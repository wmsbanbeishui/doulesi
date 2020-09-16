<?php
namespace admin\controllers;

use common\models\table\ArticleSearch;
use Yii;
use admin\controllers\base\BaseController;

class IndexController extends BaseController {
	public function actionIndex() {
		return $this->render('index');
	}

    public function actionSearch()
    {
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

        return $this->render('search', ['data' => $data]);
    }

    public function actionCreate()
    {
        $model = new ArticleSearch();
        $model->id = 3;
        $model->title = "5G快速进入我们的生活";
        $model->description = "工信部最新统计显示，截至6月底，我国5G基站累计超40万个；截至7月底，5G终端连接数已达8800万。";

        $model->insert(false);
    }
}
