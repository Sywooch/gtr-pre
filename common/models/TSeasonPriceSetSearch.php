<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TSeasonPriceSet;

/**
 * TSeasonPriceSetSearch represents the model behind the search form about `common\models\TSeasonPriceSet`.
 */
class TSeasonPriceSetSearch extends TSeasonPriceSet
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_company', 'id_season_type', 'id_route', 'adult_price', 'child_price', 'infant_price', 'created_at', 'updated_at'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
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
        $query = TSeasonPriceSet::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>[
                'defaultOrder'=>[
                'id_company'=>SORT_ASC,
               // 'id_route'=>SORT_ASC,
               // 'id_route'=>SORT_ASC
                ]
            ]
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
            'id_company' => $this->id_company,
            'id_season_type' => $this->id_season_type,
            'id_route' => $this->id_route,
            'adult_price' => $this->adult_price,
            'child_price' => $this->child_price,
            'infant_price' => $this->infant_price,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
