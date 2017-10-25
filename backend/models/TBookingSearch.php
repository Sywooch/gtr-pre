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
class TBookingSearch extends TBooking
{
    public $date;
    public $startDate;
    public $endDate;
    public $bookdate;
    public $departure;
    public $id_route;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'email', 'phone', 'currency', 'token', 'expired_time', 'datetime','startDate','endDate','bookdate'], 'safe'],
           // ['date','default','value'=>date('Y-m-d')],
            [['id_trip', 'id_payment', 'total_idr', 'exchange', 'id_status', 'id_payment_method', 'process_by','departure','id_route'], 'integer'],
            [['trip_price', 'total_price', 'send_amount'], 'number'],
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
        if(Helper::checkRoute('/booking/*')){
             $query = TBooking::find()->joinWith('idTrip.idBoat.idCompany')->joinWith('idTrip.idRoute');
        }else{
            $query = TBooking::find()->joinWith('idTrip.idBoat.idCompany')->where('t_company.id_user = :userid',[':userid'=>Yii::$app->user->identity->id])->andWhere('id_status > :idstatus',[':idstatus'=>3]);
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
            'id_payment_method' => $this->id_payment_method,
            'send_amount' => $this->send_amount,
            'process_by' => $this->process_by,
            'expired_time' => $this->expired_time,
            't_route.departure' => $this->departure,
            't_trip.id_route' => $this->id_route,
        ]);
        if ($this->date == date('Y-m-d')) {
             $query->andFilterWhere(['>','t_trip.date',$this->date]);
        }else{
            $query->andFilterWhere(['t_trip.date' => $this->date]);
        }

        $query->andFilterWhere(['between', 't_trip.date', $this->startDate, $this->endDate]);
       

        $query->andFilterWhere(['like', 't_booking.id', $this->id])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', 't_booking.datetime', $this->bookdate]);

        return $dataProvider;
    }
}
