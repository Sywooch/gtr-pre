<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TSeasonPrice;

/**
 * TSeasonPriceSearch represents the model behind the search form about `common\models\TSeasonPrice`.
 */
class TSeasonPriceSearch extends TSeasonPrice
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_season_type', 'id_trip', 'adult_price', 'child_price', 'infant_price'], 'integer'],
            [['start_date', 'end_date', 'datetime'], 'safe'],
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
        $query = TSeasonPrice::find();

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
            'id_season_type' => $this->id_season_type,
            'id_trip' => $this->id_trip,
            'adult_price' => $this->adult_price,
            'child_price' => $this->child_price,
            'infant_price' => $this->infant_price,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'datetime' => $this->datetime,
        ]);

        return $dataProvider;
    }
}
