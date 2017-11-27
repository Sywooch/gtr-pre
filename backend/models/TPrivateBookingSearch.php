<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TPrivateBooking;

/**
 * TPrivateBookingSearch represents the model behind the search form about `common\models\TPrivateBooking`.
 */
class TPrivateBookingSearch extends TPrivateBooking
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'currency', 'date_trip', 'datetime'], 'safe'],
            [['id_payment', 'id_status', 'amount_idr'], 'integer'],
            [['amount'], 'number'],
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
        $query = TPrivateBooking::find();

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
            'id_payment' => $this->id_payment,
            'id_status' => $this->id_status,
            'amount' => $this->amount,
            'amount_idr' => $this->amount_idr,
            'date_trip' => $this->date_trip,
            'datetime' => $this->datetime,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'currency', $this->currency]);

        return $dataProvider;
    }
}
