<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Population;

/**
 * PopulationSearch represents the model behind the search form of `app\models\Population`.
 */
class PopulationSearch extends Population
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'citymun_id', 'population_count'], 'integer'],
            [['region_c', 'province_c'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Population::find();

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
            'citymun_id' => $this->citymun_id,
            'population_count' => $this->population_count,
        ]);

        $query->andFilterWhere(['like', 'region_c', $this->region_c])
            ->andFilterWhere(['like', 'province_c', $this->province_c]);

        return $dataProvider;
    }
}
