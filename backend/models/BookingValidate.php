<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TBooking;
use mdm\admin\components\Helper;

/**
 * TBookingSearch represents the model behind the search form about `common\models\TBooking`.
 */
class BookingValidate extends TBooking
{
    public $date;
    public $show_all;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'currency', 'expired_time', 'datetime'], 'safe'],
            ['date','default','value'=>date('Y-m-d')],
            ['show_all','boolean'],
            ['show_all','default','value'=>false],
            [['id_trip', 'id_payment', 'total_idr', 'exchange', 'id_status', 'process_by'], 'integer'],
            [['trip_price', 'total_price'], 'number'],
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

            // $query = TBooking::find()->joinWith('idTrip.idBoat.idCompany')->where(['id_status'=>2])->orWhere(['id_status'=>3]);
        if ($this->show_all == false) {
            $query = TBooking::find()->joinWith('idTrip.idBoat.idCompany')->where(['id_status'=>2])->orWhere(['id_status'=>3]);
        }else{
            $query = TBooking::find()->joinWith('idTrip.idBoat.idCompany');
        }
       
       

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>[
                'defaultOrder'=>[
                'id_payment'=>SORT_DESC,
                //'dept_time'=>SORT_ASC
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
            'id_trip' => $this->id_trip,
            'id_payment' => $this->id_payment,
            'trip_price' => $this->trip_price,
            'total_price' => $this->total_price,
            'total_idr' => $this->total_idr,
            'exchange' => $this->exchange,
            'id_status' => $this->id_status,
            'process_by' => $this->process_by,
            'expired_time' => $this->expired_time,
            'datetime' => $this->datetime,
        ]);

       

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'currency', $this->currency]);

        return $dataProvider;
    }
}
