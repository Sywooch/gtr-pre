<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TShuttlePrice;

/**
 * TShuttlePriceSearch represents the model behind the search form about `common\models\TShuttlePrice`.
 */
class TShuttlePriceSearch extends TShuttlePrice
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_company', 'id_lokasi', 'id_shuttle_type', 'price_sharing', 'price_car', 'price_elf'], 'integer'],
            [['pickup_time', 'datetime'], 'safe'],
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
        $query = TShuttlePrice::find();

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
            'id_company' => $this->id_company,
            'id_lokasi' => $this->id_lokasi,
            'id_shuttle_type' => $this->id_shuttle_type,
            'price_sharing' => $this->price_sharing,
            'price_car' => $this->price_car,
            'price_elf' => $this->price_elf,
            'datetime' => $this->datetime,
        ]);

        $query->andFilterWhere(['like', 'pickup_time', $this->pickup_time]);

        return $dataProvider;
    }
}
