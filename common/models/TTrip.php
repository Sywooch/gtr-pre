<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "t_trip".
 *
 * @property integer $id
 * @property integer $id_boat
 * @property integer $id_route
 * @property string $date
 * @property string $dept_time
 * @property string $id_est_time
 * @property string $description
 * @property integer $status
 * @property integer $id_type_avaibility
 * @property integer $stock
 * @property integer $sold
 * @property integer $process
 * @property integer $cancel
 * @property integer $id_season
 * @property integer $adult_price
 * @property integer $child_price
 * @property string $datetime
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property TAvaibility[] $tAvaibilities
 * @property TBooking[] $tBookings
 * @property TCart[] $tCarts
 * @property TSeasonPrice[] $tSeasonPrices
 * @property TSpecialPrice[] $tSpecialPrices
 * @property TAvaibilityType $idTypeAvaibility
 * @property TBoat $idBoat
 * @property TRoute $idRoute
 * @property TStatusTrip $status0
 * @property TSeasonPriceSet $idSeason
 */
class TTrip extends \yii\db\ActiveRecord
{
    public $id_company;
    const STATUS_ON  = 1;
    const STATUS_OFF = 2;
    public $startDate;
    public $endDate;
    public $template;
    public $minDate;
    public $maxDate;
    public $company_name;
    public $islandRoute;
    const TYPE_UP   = 1;
    const TYPE_DOWN = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_trip';
    }

    public function behaviors()
    {
    return [
        TimestampBehavior::className(),
    ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_boat', 'id_route', 'date', 'dept_time', 'id_est_time', 'stock','id_company'], 'required'],
            [['id_boat', 'id_route', 'status', 'id_type_avaibility', 'stock', 'sold', 'process', 'cancel', 'id_season','id_est_time'], 'integer'],
            [['date', 'dept_time', 'datetime','startDate','endDate','islandRoute'], 'safe'],
            [['status','id_type_avaibility'], 'default', 'value' => self::STATUS_ON],
            [['status','id_type_avaibility','id_price_type'], 'in', 'range' => [self::STATUS_ON, self::STATUS_OFF]],
            [['adult_price', 'child_price'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 100],
            [['id_type_avaibility'], 'exist', 'skipOnError' => true, 'targetClass' => TAvaibilityType::className(), 'targetAttribute' => ['id_type_avaibility' => 'id']],
            [['id_boat'], 'exist', 'skipOnError' => true, 'targetClass' => TBoat::className(), 'targetAttribute' => ['id_boat' => 'id']],
            [['id_route'], 'exist', 'skipOnError' => true, 'targetClass' => TRoute::className(), 'targetAttribute' => ['id_route' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => TStatusTrip::className(), 'targetAttribute' => ['status' => 'id']],
            [['id_season'], 'exist', 'skipOnError' => true, 'targetClass' => TSeasonPriceSet::className(), 'targetAttribute' => ['id_season' => 'id']],
            [['id_price_type'], 'exist', 'skipOnError' => true, 'targetClass' => TAvaibilityType::className(), 'targetAttribute' => ['id_price_type' => 'id']],
            [['id_est_time'], 'exist', 'skipOnError' => true, 'targetClass' => TEstTime::className(), 'targetAttribute' => ['id_est_time' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_boat' => Yii::t('app', 'Boat'),
            'id_route' => Yii::t('app', 'Route'),
            'date' => Yii::t('app', 'Date'),
            'dept_time' => Yii::t('app', 'Dept Time'),
            'id_est_time' => Yii::t('app', 'Est Time'),
            'description' => Yii::t('app', 'Description'),
            'status' => Yii::t('app', 'Status'),
            'id_type_avaibility' => Yii::t('app', 'Type Avaibility'),
            'stock' => Yii::t('app', 'Stock'),
            'sold' => Yii::t('app', 'Sold'),
            'process' => Yii::t('app', 'Process'),
            'cancel' => Yii::t('app', 'Cancel'),
            'id_season' => Yii::t('app', 'Season Type'),
            'id_price_type' => Yii::t('app', 'Price Type'),
            'adult_price' => Yii::t('app', 'Adult Price'),
            'child_price' => Yii::t('app', 'Child Price'),
            'datetime' => Yii::t('app', 'Datetime'),
            'id_company' => Yii::t('app', 'Company'),
           
        ];
    }

    public static function saveRangeTrip($model,$date,$deptTime){
        $modelTrip = new TTrip();
        $modelTrip->id_boat     = $model->id_boat;
        $modelTrip->id_route    = $model->id_route;
        $modelTrip->stock       = $model->stock;
        $modelTrip->date        = $date;
        $modelTrip->dept_time   = $deptTime;
        $modelTrip->id_est_time = $model->id_est_time;
        $modelTrip->description = $model->description;
        if (($modelSeasonPrice = TSeasonPriceSet::find()->where(['id_company'=>$model->idBoat->id_company])->andWhere(['id_route'=>$modelTrip->id_route])->one()) !== null )  {
            $start_ts = strtotime($modelSeasonPrice->start_date);
            $end_ts = strtotime($modelSeasonPrice->end_date);
            $tripDate = strtotime($modelTrip->date);

            if ((($tripDate >= $start_ts) && ($tripDate <= $end_ts)) == 1) {
                $modelTrip->adult_price = $modelSeasonPrice->adult_price;
                $modelTrip->child_price = $modelSeasonPrice->child_price;
                $modelTrip->id_season   = $modelSeasonPrice->id;
                $modelTrip->id_price_type = self::STATUS_ON;
                //$modelTrip->end_date    = $model->id_season_type;
                $modelTrip->validate();
                $modelTrip->save(false);
            }else{
                $modelTrip->validate();
                $modelTrip->save(false);
            }
        }else{
            $modelTrip->validate();
            $modelTrip->save(false);
        }
        return true;
    }



   /* protected function generatePrice($modelTrip){
        if (($modelSeasonPrice = TSeasonPriceSet::find()->where(['id_company'=>$modelTrip->id_company])->andWhere(['id_route'=>$modelTrip->id_route])->one()) !== null )  {
            $start_ts = strtotime($modelSeasonPrice->start_date);
            $end_ts = strtotime($modelSeasonPrice->end_date);
            $tripDate = strtotime($modelTrip->date);

            if ((($tripDate >= $start_ts) && ($tripDate <= $end_ts)) == 1) {
                $modelTrip->adult_price = $modelSeasonPrice->adult_price;
                $modelTrip->child_price = $modelSeasonPrice->child_price;
                $modelTrip->id_season   = $modelSeasonPrice->id;
                $modelTrip->id_price_type = self::STATUS_ON;
                //$modelTrip->end_date    = $model->id_season_type;
                $modelTrip->validate();
                $modelTrip->save(false);
            }else{
                return true;
            }
        }else{
            return true;
        }
        
    }*/
    public function getIdEstTime()
    {
        return $this->hasOne(TEstTime::className(), ['id' => 'id_est_time']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTAvaibility()
    {
        return $this->hasOne(TAvaibility::className(), ['id_trip' => 'id']);
    }

    public function getIdPriceType()
    {
        return $this->hasOne(TAvaibilityType::className(), ['id' => 'id_price_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTBookings()
    {
        return $this->hasMany(TBooking::className(), ['id_trip' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTCarts()
    {
        return $this->hasMany(TCart::className(), ['id_trip' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTSeasonPrices()
    {
        return $this->hasMany(TSeasonPrice::className(), ['id_trip' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTSpecialPrices()
    {
        return $this->hasMany(TSpecialPrice::className(), ['id_trip' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTypeAvaibility()
    {
        return $this->hasOne(TAvaibilityType::className(), ['id' => 'id_type_avaibility']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdBoat()
    {
        return $this->hasOne(TBoat::className(), ['id' => 'id_boat']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdRoute()
    {
        return $this->hasOne(TRoute::className(), ['id' => 'id_route']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(TStatusTrip::className(), ['id' => 'status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSeason()
    {
        return $this->hasOne(TSeasonPriceSet::className(), ['id' => 'id_season']);
    }

    public static function getAvailableTrip(array $formData){
        return TTrip::find()
        ->where(['date'=>$formData['date']])
        ->andWhere(['id_route'=>$formData['id_route']])
        ->andWhere('t_trip.id_price_type IS NOT :priceid',['priceid'=>null])
        ->andWhere('t_trip.stock >= :totalPax',[':totalPax'=>$formData['pax']])
        ->andWhere(['status'=>self::STATUS_ON])
        ->all();
    }

    public static function getDynamicAvailableTrip(array $data){
        $groupIdRoute[] = "OR";
        foreach($data['idRoutes'] as $idRoute){
             $groupIdRoute[] = ['=','t_trip.id_route',$idRoute['id']];         
       }
        $modelTrip = TTrip::find()
        ->joinWith(['idBoat.idCompany','idRoute.departureHarbor AS DeparturePort','idRoute.arrivalHarbor as ArrivalPort','idEstTime'])
        ->where($groupIdRoute)
        ->andWhere(['t_trip.date'=>$data['date']])
        ->andWhere(['IS NOT','t_trip.id_price_type',null])
        ->andWhere(['>=','t_trip.stock',$data['pax']])
        ->andWhere(['status'=>self::STATUS_ON])
        ->orderBy(['t_trip.adult_price'=>SORT_ASC])
        ->asArray()->all();
        return $modelTrip;
    }

    public static function changeAvailability(array $data){
        $trip = TTrip::find()->joinWith(['idRoute.departureHarbor departure','idRoute.arrivalHarbor as arrival','idBoat'])
        ->where([
            't_trip.id_boat'                                       => $data['id_boat'],
            'CONCAT( departure.id_island, "-", arrival.id_island)' => $data['island_route'],
            't_trip.date'                                          => $data['date'],
            't_trip.dept_time'                                     => $data['dept_time']
        ])
        ->all();
        if ($data['changeType'] == self::TYPE_DOWN) {
            foreach ($trip as $key => $valTrip) {
                $valTrip->stock = $valTrip->stock-$data['totalPax'];
                $valTrip->validate();
                $valTrip->save(false);
             
            }
        }elseif ($data['changeType'] == self::TYPE_UP) {
            foreach ($trip as $key => $valTrip) {
                $valTrip->stock = $valTrip->stock+$data['totalPax'];
                $valTrip->validate();
                $valTrip->save(false);
             
            }
        }

        return true;
    }
}
