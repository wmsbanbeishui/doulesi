<?php

namespace common\models\table;

use common\models\base\AnswerBase;

class Answer extends AnswerBase
{
	public function getQuestions()
    {
        return $this->hasOne(Question::className(), ['id' => 'question_id']);
    }

    public function getOptions()
    {
        return $this->hasOne(Option::className(), ['id' => 'option_id']);
    }
}
