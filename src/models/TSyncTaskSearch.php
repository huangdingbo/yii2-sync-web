<?php

namespace dsj\sync\web\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TSyncTaskSearch represents the model behind the search form of `backend\modules\sync\models\TSyncTask`.
 */
class TSyncTaskSearch extends TSyncTask
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'source_db_id', 'aid_db_id', 'pid', 'start_timestamp', 'end_timestamp', 'execute_time'], 'integer'],
            [['sync_rule', 'sync_tables', 'is_open', 'extra', 'status', 'execute_rule','name','process_num'], 'safe'],
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
        $query = TSyncTask::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'source_db_id' => $this->source_db_id,
            'aid_db_id' => $this->aid_db_id,
            'pid' => $this->pid,
            'start_timestamp' => $this->start_timestamp,
            'end_timestamp' => $this->end_timestamp,
            'execute_time' => $this->execute_time,
        ]);

        $query->andFilterWhere(['like', 'sync_rule', $this->sync_rule])
            ->andFilterWhere(['like', 'sync_tables', $this->sync_tables])
            ->andFilterWhere(['like', 'is_open', $this->is_open])
            ->andFilterWhere(['like', 'extra', $this->extra])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'execute_rule', $this->execute_rule]);

        return $dataProvider;
    }
}
