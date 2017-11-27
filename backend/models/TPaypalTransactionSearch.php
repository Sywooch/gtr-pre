<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TPaypalTransaction;

/**
 * TPaypalTransactionSearch represents the model behind the search form about `common\models\TPaypalTransaction`.
 */
class TPaypalTransactionSearch extends TPaypalTransaction
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_payer', 'currency', 'description', 'payment_token', 'paypal_time', 'datetime'], 'safe'],
            [['amount'], 'number'],
            [['id_intent', 'id_status'], 'integer'],
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
        $query = TPaypalTransaction::find();

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
            'amount' => $this->amount,
            'id_intent' => $this->id_intent,
            'id_status' => $this->id_status,
            'datetime' => $this->datetime,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'id_payer', $this->id_payer])
            ->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'payment_token', $this->payment_token])
            ->andFilterWhere(['like', 'paypal_time', $this->paypal_time]);

        return $dataProvider;
    }
}
