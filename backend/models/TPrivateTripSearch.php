<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TPrivateTrip;

/**
 * TPrivateTripSearch represents the model behind the search form about `common\models\TPrivateTrip`.
 */
class TPrivateTripSearch extends TPrivateTrip
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_route', 'min_price', 'max_person', 'person_price', 'min_time', 'max_time'], 'integer'],
            [['datetime'], 'safe'],
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
        $query = TPrivateTrip::find();

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
            'id_route' => $this->id_route,
            'min_price' => $this->min_price,
            'max_person' => $this->max_person,
            'person_price' => $this->person_price,
            'min_time' => $this->min_time,
            'max_time' => $this->max_time,
            'datetime' => $this->datetime,
        ]);

        return $dataProvider;
    }
}
