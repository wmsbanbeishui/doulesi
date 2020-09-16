<?php

namespace common\models\table;

use yii\elasticsearch\ActiveRecord;

class ArticleSearch extends ActiveRecord
{
    public function attributes()
    {
        return ['id', 'title', 'description'];
    }

    public static function index()
    {
        return 'yii2_article'; // 创建ES的索引
    }

    public static function type()
    {
        return "_doc"; // 索引类型为_doc
    }
}
