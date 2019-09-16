<?php

namespace admin\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\table\Record;

/**
 * RecordSearch represents the model behind the search form of `common\models\table\Record`.
 */
class RecordSearch extends Record
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'admin_id'], 'integer'],
            [['record', 'date', 'create_time', 'update_time'], 'safe'],
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
        $query = Record::find();

		$admin_id = Yii::$app->user->getId();
		if (Yii::$app->authManager->getRolesByUser($admin_id) != 'admin' && $admin_id != 1) {
			$query->andWhere(['admin_id' => $admin_id]);
		}

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort' => [
				'defaultOrder' => ['date' => SORT_DESC, 'admin_id' => SORT_DESC, 'id' => SORT_DESC]
			],
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
            'date' => $this->date,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'record', $this->record]);

        return $dataProvider;
    }
}
