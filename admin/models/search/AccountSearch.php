<?php

namespace admin\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\table\Account;

/**
 * AccountSearch represents the model behind the search form of `common\models\table\Account`.
 */
class AccountSearch extends Account
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'admin_id', 'order_index'], 'integer'],
            [['title', 'account', 'password', 'url', 'create_at', 'update_at'], 'safe'],
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
        $query = Account::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['order_index' => SORT_DESC, 'id' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'admin_id' => $this->admin_id,
            'order_index' => $this->order_index,
            'create_at' => $this->create_at,
            'update_at' => $this->update_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'account', $this->account])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
