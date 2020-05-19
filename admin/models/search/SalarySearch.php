<?php

namespace admin\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\table\Salary;

/**
 * SalarySearch represents the model behind the search form of `common\models\table\Salary`.
 */
class SalarySearch extends Salary
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'admin_id', 'status'], 'integer'],
            [['salary'], 'number'],
            [['date', 'remark', 'create_time', 'update_time'], 'safe'],
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Salary::find();

        // add conditions that should always apply here

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            //return $dataProvider;
            echo '111';exit;
        }

        if (empty($this->date)) {
            $start = date('Y/01/01');
            $end = date('Y/12/31');
            $this->date = $start.' - '.$end;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'admin_id' => $this->admin_id,
            'salary' => $this->salary,
            'status' => $this->status,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->timeRangeFilter('date', $this->date);
        $query->andFilterWhere(['like', 'remark', $this->remark]);
        $sum_query = clone $query;
        $sum_query->select(['sum' => 'SUM(salary)']);
        $sum = $sum_query->scalar();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['date' => SORT_DESC, 'admin_id' => SORT_DESC, 'id' => SORT_ASC]],
        ]);

        return ['dataProvider' => $dataProvider, 'sum' => $sum];
    }
}
