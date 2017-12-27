<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_booking".
 *
 * @property string $id
 * @property integer $id_trip
 * @property integer $id_payment
 * @property double $trip_price
 * @property double $total_price
 * @property string $currency
 * @property integer $total_idr
 * @property integer $exchange
 * @property integer $id_status
 * @property integer $id_payment_method
 * @property double $send_amount
 * @property string $
 * @property integer $process_by
 * @property string $datetime
 *
 * @property TBookingStatus $idStatus
 * @property TPaymentMethod $idPaymentMethod
 * @property TPayment $idCustomer
 * @property TKurs $currency0
 * @property TTrip $idTrip
 * @property TDrop $tDrop
 * @property TPickup $tPickup
 */
class TBooking extends \yii\db\ActiveRecord
{
    const STATUS_ON_BOOK        = 1; // ADULT
    const STATUS_UNPAID         = 2; //CHILD
    const STATUS_VALIDATION     = 3; //INFANT
    const STATUS_PAID           = 4;
    const STATUS_SUCCESS        = 5;
    const STATUS_REFUND_PARTIAL = 6;
    const STATUS_REFUND_FULL    = 7;
    const STATUS_EXPIRED        = 99;
    const STATUS_INVALID        = 100;
    public $date;
    public $departurePort;
    public $arrivalPort;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_booking';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','id_payment', 'id_trip', 'trip_price', 'total_price', 'currency', 'total_idr', 'exchange'], 'required'],
            [['id_trip', 'total_idr', 'exchange', 'id_status', 'process_by','departurePort','arrivalPort'], 'integer'],
            [['trip_price', 'total_price'], 'number'],
            [['datetime','date'], 'safe'],
            [['id'], 'string', 'max' => 6],
            [['currency'], 'string', 'max' => 5],
            [['id_status'],'in','range'=>[self::STATUS_ON_BOOK, self::STATUS_UNPAID, self::STATUS_VALIDATION, self::STATUS_PAID, self::STATUS_SUCCESS, self::STATUS_REFUND_PARTIAL, self::STATUS_REFUND_FULL, self::STATUS_EXPIRED, self::STATUS_INVALID]],
            [['id_status'], 'exist', 'skipOnError' => true, 'targetClass' => TBookingStatus::className(), 'targetAttribute' => ['id_status' => 'id']],
            [['currency'], 'exist', 'skipOnError' => true, 'targetClass' => TKurs::className(), 'targetAttribute' => ['currency' => 'currency']],
            [['id_trip'], 'exist', 'skipOnError' => true, 'targetClass' => TTrip::className(), 'targetAttribute' => ['id_trip' => 'id']],
             [['id_payment'], 'exist', 'skipOnError' => true, 'targetClass' => TPayment::className(), 'targetAttribute' => ['id_payment' => 'id']],
        ];
    }


public function generateBookingNumber($attribute, $length = 5){
    $pool = array_merge(range(0,9),range('A', 'Z')); 
    for($i=0; $i < $length; $i++) {
        $key[] = $pool[mt_rand(0, count($pool) - 1)];
    }
    // if ($type == '2') {
         //   $kodeBooking = "G".join($key)."Y";
       // }else{
            $kodeBooking = "F".join($key);
       // }          
     
    if(!$this->findOne([$attribute => $kodeBooking])) {
        return $kodeBooking;
    }else{
        return $this->generateBookingNumber($attribute,$length);
    }
            
}

    public static function addFastboatBooking(array $data){
        $modelFastboatBooking               = new TBooking();
        $modelFastboatBooking->id           = $modelFastboatBooking->generateBookingNumber("id");
        $modelFastboatBooking->id_trip      = $data['id_trip'];
        $modelFastboatBooking->id_payment   = $data['id_payment'];
        $modelFastboatBooking->trip_price   = $data['trip_price'];
        $modelFastboatBooking->total_price  = $data['total_price'];
        $modelFastboatBooking->currency     = $data['currency'];
        $modelFastboatBooking->total_idr    = $data['total_idr'];
        $modelFastboatBooking->exchange     = $data['exchange'];
        $modelFastboatBooking->expired_time = date('Y-m-d H:i:s', strtotime('+2 HOURS'));
        $modelFastboatBooking->validate();
        $modelFastboatBooking->save(false);
        return $modelFastboatBooking->id;
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Book Code'),
            'id_trip' => Yii::t('app', 'Trip'),
            'id_payment' => Yii::t('app', 'Payment'),
            'trip_price' => Yii::t('app', 'Trip Price'),
            'total_price' => Yii::t('app', 'Total Price'),
            'currency' => Yii::t('app', 'Currency'),
            'total_idr' => Yii::t('app', 'Total Idr'),
            'exchange' => Yii::t('app', 'Exchange'),
            'id_status' => Yii::t('app', 'Status'),
            'process_by' => Yii::t('app', 'Process By'),
            'datetime' => Yii::t('app', 'Datetime'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdStatus()
    {
        return $this->hasOne(TBookingStatus::className(), ['id' => 'id_status']);
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPayment()
    {
        return $this->hasOne(TPayment::className(), ['id' => 'id_payment']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency0()
    {
        return $this->hasOne(TKurs::className(), ['currency' => 'currency']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTrip()
    {
        return $this->hasOne(TTrip::className(), ['id' => 'id_trip']);
    }

    public function getTPassengers()
    {
        return $this->hasMany(TPassenger::className(), ['id_booking' => 'id'])->orderBy(['id_type' => SORT_ASC]);
    }
    public function getAffectedPassengers()
    {
        return $this->hasMany(TPassenger::className(), ['id_booking' => 'id'])->where(['!=','id_type',self::STATUS_VALIDATION]); // Bukan Bayi
    }
    public function getAdultPassengers()
    {
        return $this->hasMany(TPassenger::className(), ['id_booking' => 'id'])->where(['id_type'=>self::STATUS_ON_BOOK]); 
    }
    public function getChildPassengers()
    {
        return $this->hasMany(TPassenger::className(), ['id_booking' => 'id'])->where(['id_type'=>self::STATUS_UNPAID]);
    }
    public function getInfantPassengers()
    {
        return $this->hasMany(TPassenger::className(), ['id_booking' => 'id'])->where(['id_type'=>self::STATUS_VALIDATION]);
    }

    public function getPassengersByType($type)
    {
        return $this->hasMany(TPassenger::className(), ['id_booking' => 'id'])->where(['id_type'=>$type]);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTShuttles()
    {
        return $this->hasOne(TShuttleLocationTmp::className(), ['id_booking' => 'id']);
    }

    public function getShuttleTmp()
    {
        return $this->hasOne(TShuttleLocationTmp::className(), ['id_booking' => 'id']);
    }

    public static function getBookingGroupPayment($model){
        return TBooking::find()->joinWith(['idTrip.idBoat'])->where(['t_boat.id_company'=>$model['idTrip']['idBoat']['id_company']])->andWhere(['t_trip.id_route'=>$model['idTrip']['id_route']])->andWhere(['t_trip.date'=>$model['idTrip']['date']])->andWhere(['t_trip.dept_time'=>$model['idTrip']['dept_time']])->andWhere(['between','id_status',TBooking::STATUS_PAID,TBooking::STATUS_REFUND_FULL])->all();
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if ($this->id_status == self::STATUS_INVALID || $this->id_status == self::STATUS_EXPIRED ) {
            $modelTrip          = $this->idTrip;
            $affectedPassengers = count($this->affectedPassengers);
            $modelTrip->stock   = $modelTrip->stock+$affectedPassengers;
            $modelTrip->process = $modelTrip->process-$affectedPassengers;
            $modelTrip->cancel  = $modelTrip->cancel+$affectedPassengers;
            $modelTrip->save(false);
        }
        
        return true;
    }

    // public function afterSave( $insert, $changedAttributes ){
    //     if ($changedAttributes['id_trip']) {
    //         $modelTrip          = $this->idTrip;
    //         $affectedPassengers = count($this->affectedPassengers);
    //         $modelTrip->stock   = $modelTrip->stock-$affectedPassengers;
    //         $modelTrip->cancel  = $modelTrip->cancel+$affectedPassengers;
    //         $modelTrip->save(false);
    //     }
    //     return true;
    // }
    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }
        $modelTrip          = $this->idTrip;
        $affectedPassengers = count($this->affectedPassengers);
        $modelTrip->stock   = $modelTrip->stock+$affectedPassengers;
        $modelTrip->process = $modelTrip->process-$affectedPassengers;
        $modelTrip->cancel  = $modelTrip->cancel+$affectedPassengers;
        $modelTrip->save(false);
        return true;
    }
}
