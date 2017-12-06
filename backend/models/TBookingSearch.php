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
    const STATUS_VALIDATION = 3;
    const STATUS_PAID       = 4;
    const LAYOUT_FLAT       = 'flat';
    const LAYOUT_GROUP      = 'group';
    public $date;
    public $startDate;
    public $endDate;
    public $bookdate;
    public $departure;
    public $id_route;
    public $id_company;
    public $rangeType;
    public $table_layout;
    public $buyer_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'currency', 'expired_time', 'datetime','startDate','endDate','bookdate','date','table_layout','buyer_name'], 'safe'],
            [['table_layout'],'default','value'=>self::LAYOUT_FLAT],
            [['id_trip', 'id_payment', 'total_idr', 'exchange', 'id_status', 'process_by','departure','id_route','id_company','rangeType'], 'integer'],
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

    public function summarySearch($params){
        $this->load($params);

        if(Helper::checkRoute('/booking/*')){

            if ($this->table_layout == 'group') {
                $query = TBooking::find()->joinWith(['idTrip.idBoat','idTrip.idRoute','idPayment'])->where(['between','id_status',TBooking::STATUS_PAID,TBooking::STATUS_REFUND_FULL])->groupBy(['t_boat.id_company','t_trip.id_route','t_trip.date','t_trip.dept_time'])->orderBy(['t_boat.id_company'=>SORT_ASC,'t_trip.id_route'=>SORT_ASC,'t_trip.dept_time'=>SORT_ASC,'t_trip.date'=>SORT_ASC]);
            }else{
                 $query = TBooking::find()->joinWith(['idTrip.idBoat','idTrip.idRoute','idPayment'])->where(['between','id_status',TBooking::STATUS_PAID,TBooking::STATUS_REFUND_FULL])->orderBy(['t_booking.datetime'=>SORT_DESC]);
            }
        
       }else{
        $query = TBooking::find()->joinWith(['idTrip.idBoat.idCompany','idTrip.idRoute'])->where(['t_company.id_user'=>Yii::$app->user->identity->id])->andWhere(['between','id_status',TBooking::STATUS_PAID,TBooking::STATUS_REFUND_FULL])->orderBy(['t_trip.id_route'=>SORT_ASC,'t_trip.dept_time'=>SORT_ASC]);
       }

        // add conditions that should always apply here
      
        
         if ($this->table_layout == 'group' ) {
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
        }else{
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'sort'=>[
                     'defaultOrder'=>[
                    'datetime'=>SORT_DESC,
                    //'dept_time'=>SORT_ASC
                    ]
                ]
            ]);
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

       

        if ($this->startDate != null && $this->endDate != null && $this->rangeType != null) {
            if ($this->rangeType == '1') {
                $query->andFilterWhere(['between', 't_trip.date', $this->startDate, $this->endDate]);
            }elseif ($this->rangeType == '2') {
                $query->andFilterWhere(['between', 'DATE_FORMAT(t_booking.datetime,\'%Y-%m-%d\')', $this->startDate, $this->endDate]);
            }
            
        }else{
            if ($this->date == null && $this->bookdate == null) {
            //$query->andFilterWhere(['>','t_trip.date',date('Y-m-d')]);
            }else{
             $query->andFilterWhere(['t_trip.date' => $this->date]);
            }
        }

         // grid filtering conditions
        $query->andFilterWhere([
            'id_status' => $this->id_status,
            'process_by' => $this->process_by,
            'expired_time' => $this->expired_time,
            't_route.departure' => $this->departure,
            't_trip.id_route' => $this->id_route,
            't_boat.id_company'=>$this->id_company,
            't_trip.date' => $this->date,

        ]);


    
        $query->andFilterWhere(['like', 't_booking.id', $this->id])
            ->andFilterWhere(['like', 't_booking.datetime', $this->bookdate])
            ->andFilterWhere(['like', 't_payment.name', $this->buyer_name]);

        return $dataProvider;
    }


    // public function Flatsearch($params)
    // {
    //     $query = TBooking::find()->joinWith(['idTrip.idBoat','idTrip.idRoute'])->where(['between','id_status',TBooking::STATUS_PAID,TBooking::STATUS_REFUND_FULL]);
     

    //     // add conditions that should always apply here

    //     $dataProvider = new ActiveDataProvider([
    //         'query' => $query,
    //     ]);

    //     $this->load($params);

    //     if (!$this->validate()) {
    //         // uncomment the following line if you do not want to return any records when validation fails
    //         // $query->where('0=1');
    //         return $dataProvider;
    //     }

       

    //     if ($this->startDate != null && $this->endDate != null && $this->rangeType != null) {
    //         if ($this->rangeType == '1') {
    //             $query->andFilterWhere(['between', 't_trip.date', $this->startDate, $this->endDate]);
    //         }elseif ($this->rangeType == '2') {
    //             $query->andFilterWhere(['between', 'DATE_FORMAT(t_booking.datetime,\'%Y-%m-%d\')', $this->startDate, $this->endDate]);
    //         }
            
    //     }else{
    //         if ($this->date == null && $this->bookdate == null) {
    //         //$query->andFilterWhere(['>','t_trip.date',date('Y-m-d')]);
    //         }else{
    //          $query->andFilterWhere(['t_trip.date' => $this->date]);
    //         }
    //     }

    //      // grid filtering conditions
    //     $query->andFilterWhere([
    //         'id_status' => $this->id_status,
    //         'process_by' => $this->process_by,
    //         'expired_time' => $this->expired_time,
    //         't_route.departure' => $this->departure,
    //         't_trip.id_route' => $this->id_route,
    //         't_boat.id_company'=>$this->id_company,
    //         't_trip.date' => $this->date,

    //     ]);


    
    //     $query->andFilterWhere(['like', 't_booking.id', $this->id])
    //         ->andFilterWhere(['like', 't_booking.datetime', $this->bookdate]);

    //     return $dataProvider;
    // }
}
