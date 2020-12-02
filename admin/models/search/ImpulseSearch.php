<?php

namespace admin\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\table\Impulse;

/**
 * ImpulseSearch represents the model behind the search form of `common\models\table\Impulse`.
 */
class ImpulseSearch extends Impulse
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'admin_id'], 'integer'],
            [['date', 'type', 'create_time', 'update_time'], 'safe'],
            [['amount'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * @param $params
     * @return array
     */
    public function search($params)
    {
        $query = Impulse::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            echo '111';exit;
        }

        if (empty($this->date)) {
            $start = date('Y/m/01');
            $end = date('Y/m/t');
            $this->date = $start.' - '.$end;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'admin_id' => $this->admin_id,
            'amount' => $this->amount,
            'type' => $this->type,
        ]);

        $query->timeRangeFilter('date', $this->date);

        $query->andFilterWhere(['like', 'remark', $this->remark]);

        $sum_query = clone $query;
        $sum_query->select(['sum_amount' => 'SUM(amount)']);
        $sum_amount = $sum_query->scalar();

        //echo $query->createCommand()->getRawSql();exit;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            //'pagination' => ['pageSize' => 15],
            'sort' => ['defaultOrder' => ['date' => SORT_DESC, 'admin_id' => SORT_DESC, 'id' => SORT_ASC]],
        ]);

        return ['dataProvider' => $dataProvider, 'sum_amount' => $sum_amount];
    }
}
