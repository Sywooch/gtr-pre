<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TPayment;

/**
 * TBookingSearch represents the model behind the search form about `common\models\TBooking`.
 */
class TPaymentSearch extends TPayment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'email', 'phone', 'currency', 'token', 'exp', 'datetime'], 'safe'],
            [['exchange', 'status', 'id_payment_method'], 'integer'],
            [['total_payment', 'send_amount'], 'number'],
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
        $query = TPayment::find();

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
            'total_payment' => $this->total_payment,
            'total_payment_idr' => $this->total_payment_idr,
            'exchange' => $this->exchange,
            'status' => $this->status,
            'id_payment_method' => $this->id_payment_method,
            'send_amount' => $this->send_amount,
            'exp' => $this->exp,
            'update_at' => $this->update_at,

        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'token', $this->token]);

        return $dataProvider;
    }
}
