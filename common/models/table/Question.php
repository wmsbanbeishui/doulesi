<?php

namespace common\models\table;

use common\models\base\QuestionBase;

class Question extends QuestionBase
{
    public function getOptions()
    {
        return $this->hasMany(Option::className(), ['question_id' => 'id']);
    }

}
