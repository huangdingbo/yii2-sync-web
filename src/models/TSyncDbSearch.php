<?php

namespace dsj\sync\web\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TSyncDbSearch represents the model behind the search form of `backend\modules\sync\models\TSyncDb`.
 */
class TSyncDbSearch extends TSyncDb
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'port'], 'integer'],
            [['type', 'name', 'db_type', 'host', 'db_name', 'username', 'password', 'connect_charset','failed_num'], 'safe'],
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
        $query = TSyncDb::find();

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
            'port' => $this->port,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'db_type', $this->db_type])
            ->andFilterWhere(['like', 'host', $this->host])
            ->andFilterWhere(['like', 'db_name', $this->db_name])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'connect_charset', $this->connect_charset]);

        return $dataProvider;
    }
}
