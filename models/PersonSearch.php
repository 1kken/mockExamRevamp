<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Person;

/**
 * PersonSearch represents the model behind the search form of `app\models\Person`.
 */
class PersonSearch extends Person
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sex', 'citymun_id', 'status'], 'integer'],
            [['first_name', 'last_name', 'birthdate', 'region_c', 'province_c', 'district_c', 'contact_info', 'date_created', 'date_update'], 'safe'],
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
        $query = Person::find();

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
            'birthdate' => $this->birthdate,
            'sex' => $this->sex,
            'citymun_id' => $this->citymun_id,
            'status' => $this->status,
            'date_created' => $this->date_created,
            'date_update' => $this->date_update,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'region_c', $this->region_c])
            ->andFilterWhere(['like', 'province_c', $this->province_c])
            ->andFilterWhere(['like', 'district_c', $this->district_c])
            ->andFilterWhere(['like', 'contact_info', $this->contact_info]);

        return $dataProvider;
    }
}
