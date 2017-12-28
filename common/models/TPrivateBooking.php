<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_private_booking".
 *
 * @property string $id
 * @property integer $id_payment
 * @property integer $id_operator
 * @property integer $id_status
 * @property double $amount
 * @property string $currency
 * @property integer $amount_idr
 * @property string $date_trip
 * @property string $datetime
 *
 * @property TKurs $currency0
 * @property TPrivateOperator $idOperator
 * @property TPayment $idPayment
 * @property TBookingStatus $idStatus
 * @property TPrivatePassenger[] $tPrivatePassengers
 */
class TPrivateBooking extends \yii\db\ActiveRecord
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
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_private_booking';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_payment','id_trip', 'id_status', 'amount', 'currency', 'amount_idr', 'date_trip', 'datetime'], 'required'],
            [['id_payment', 'id_operator', 'id_status', 'amount_idr','id_trip'], 'integer'],
            [['amount'], 'number'],
            [['date_trip', 'datetime'], 'safe'],
            [['id'], 'string', 'max' => 6],
            [['note'], 'string'],
            [['currency'], 'string', 'max' => 5],
            [['id_status'],'in','range'=>[self::STATUS_ON_BOOK, self::STATUS_UNPAID, self::STATUS_VALIDATION, self::STATUS_PAID, self::STATUS_SUCCESS, self::STATUS_REFUND_PARTIAL, self::STATUS_REFUND_FULL, self::STATUS_EXPIRED, self::STATUS_INVALID]],
            [['currency'], 'exist', 'skipOnError' => true, 'targetClass' => TKurs::className(), 'targetAttribute' => ['currency' => 'currency']],
            [['id_operator'], 'exist', 'skipOnError' => true, 'targetClass' => TPrivateOperator::className(), 'targetAttribute' => ['id_operator' => 'id']],
            [['id_payment'], 'exist', 'skipOnError' => true, 'targetClass' => TPayment::className(), 'targetAttribute' => ['id_payment' => 'id']],
            [['id_status'], 'exist', 'skipOnError' => true, 'targetClass' => TBookingStatus::className(), 'targetAttribute' => ['id_status' => 'id']],
            [['id_trip'], 'exist', 'skipOnError' => true, 'targetClass' => TPrivateTrip::className(), 'targetAttribute' => ['id_trip' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_payment' => Yii::t('app', 'Payment'),
            'id_operator' => Yii::t('app', 'Operator'),
            'id_status' => Yii::t('app', 'Status'),
            'amount' => Yii::t('app', 'Amount'),
            'note' => Yii::t('app', 'Note'),
            'currency' => Yii::t('app', 'Currency'),
            'amount_idr' => Yii::t('app', 'Amount Idr'),
            'date_trip' => Yii::t('app', 'Date Trip'),
            'datetime' => Yii::t('app', 'Datetime'),
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
                $kodeBooking = "P".join($key);
           // }          
         
        if(!$this->findOne([$attribute => $kodeBooking])) {
            return $kodeBooking;
        }else{
            return $this->generateBookingNumber($attribute,$length);
        }
                
    }

    public static function addPrivateBooking(array $data){

        $modelPrivateBooking             = new TPrivateBooking();
        $modelPrivateBooking->id         = $modelPrivateBooking->generateBookingNumber("id");
        $modelPrivateBooking->id_payment = $data['id_payment'];
        $modelPrivateBooking->id_trip    = $data['id_trip'];
        $modelPrivateBooking->id_status  = $data['id_status'];
        $modelPrivateBooking->amount     = $data['amount'];
        $modelPrivateBooking->currency   = $data['currency'];
        $modelPrivateBooking->amount_idr = $data['amount_idr'];
        $modelPrivateBooking->date_trip  = $data['date_trip'];
        $modelPrivateBooking->note       = $data['note'];
        $modelPrivateBooking->validate();
        $modelPrivateBooking->save(false);

        return $modelPrivateBooking->id;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency0()
    {
        return $this->hasOne(TKurs::className(), ['currency' => 'currency']);
    }

    public function getIdTrip()
    {
        return $this->hasOne(TPrivateTrip::className(), ['id' => 'id_trip']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdOperator()
    {
        return $this->hasOne(TPrivateOperator::className(), ['id' => 'id_operator']);
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
    public function getIdStatus()
    {
        return $this->hasOne(TBookingStatus::className(), ['id' => 'id_status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTPassengers()
    {
        return $this->hasMany(TPrivatePassenger::className(), ['id_booking' => 'id'])->orderBy(['id_type'=>SORT_ASC]);
    }

    public function getAffectedPassengers()
    {
        return $this->hasMany(TPrivatePassenger::className(), ['id_booking' => 'id'])->where(['!=','id_type',self::STATUS_VALIDATION]); // Bukan Bayi
    }
    public function getAdultPassengers()
    {
        return $this->hasMany(TPrivatePassenger::className(), ['id_booking' => 'id'])->where(['id_type'=>self::STATUS_ON_BOOK]); 
    }
    public function getChildPassengers()
    {
        return $this->hasMany(TPrivatePassenger::className(), ['id_booking' => 'id'])->where(['id_type'=>self::STATUS_UNPAID]);
    }
    public function getInfantPassengers()
    {
        return $this->hasMany(TPrivatePassenger::className(), ['id_booking' => 'id'])->where(['id_type'=>self::STATUS_VALIDATION]);
    }
}
