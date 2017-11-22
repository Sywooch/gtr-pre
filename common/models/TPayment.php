<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_payment".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property integer $id_payment_method
 * @property double $total_payment
 * @property integer $total_payment_idr
 * @property string $currency
 * @property integer $exchange
 * @property double $send_amount
 * @property string $token
 * @property integer $status
 * @property string $exp
 * @property string $update_at
 *
 * @property TBooking[] $tBookings
 * @property TMailQueue[] $tMailQueues
 * @property TKurs $currency0
 * @property TPaymentMethod $idPaymentMethod
 * @property TPaymentStatus $status0
 * @property TPaypalTransaction $tPaypalTransaction
 */
class TPayment extends \yii\db\ActiveRecord
{
    const STATUS_UNCONFIRMED          = 1; //SAME FOR PAYPAL PAYMENT METHOD
    const STATUS_PENDING              = 2; // SAME FOR BANK TRANSFER PAYMENT METHOD
    const STATUS_CONFIRM_NOT_RECEIVED = 3; //SAME FOR COLLECT PAYMENT METHOD
    const STATUS_CONFIRM_RECEIVED     = 4;
    const STATUS_PARTIAL_REFUND       = 5;
    const STATUS_FULl_REFUND          = 6;
    const STATUS_EXPIRED              = 99;
    const STATUS_INVALID              = 100;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'phone', 'total_payment', 'total_payment_idr', 'currency', 'exchange', 'token'], 'required'],
            [['id_payment_method', 'total_payment_idr', 'exchange', 'status'], 'integer'],
            [['total_payment', 'send_amount'], 'number'],
            [['exp', 'update_at'], 'safe'],
            [['name', 'email'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 20],
            [['currency'], 'string', 'max' => 5],
            [['token'], 'string', 'max' => 25],
            [['token'], 'unique'],
            [['status'], 'default', 'value' => self::STATUS_UNCONFIRMED],
            [['status'], 'in', 'range' => [self::STATUS_UNCONFIRMED, self::STATUS_PENDING, self::STATUS_CONFIRM_NOT_RECEIVED, self::STATUS_CONFIRM_RECEIVED, self::STATUS_PARTIAL_REFUND, self::STATUS_FULl_REFUND, self::STATUS_EXPIRED , self::STATUS_INVALID, self::STATUS_INVALID]],
            [['id_payment_method'],'in','range'=>[self::STATUS_UNCONFIRMED, self::STATUS_CONFIRM_NOT_RECEIVED]],
            [['currency'], 'exist', 'skipOnError' => true, 'targetClass' => TKurs::className(), 'targetAttribute' => ['currency' => 'currency']],
            [['id_payment_method'], 'exist', 'skipOnError' => true, 'targetClass' => TPaymentMethod::className(), 'targetAttribute' => ['id_payment_method' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => TPaymentStatus::className(), 'targetAttribute' => ['status' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'id_payment_method' => Yii::t('app', 'Id Payment Method'),
            'total_payment' => Yii::t('app', 'Total Payment'),
            'total_payment_idr' => Yii::t('app', 'Total Payment Idr'),
            'currency' => Yii::t('app', 'Currency'),
            'exchange' => Yii::t('app', 'Exchange'),
            'send_amount' => Yii::t('app', 'Send Amount'),
            'token' => Yii::t('app', 'Token'),
            'status' => Yii::t('app', 'Status'),
            'exp' => Yii::t('app', 'Exp'),
            'update_at' => Yii::t('app', 'Update At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTBookings()
    {
        return $this->hasMany(TBooking::className(), ['id_payment' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTMailQueues()
    {
        return $this->hasMany(TMailQueue::className(), ['id_payment' => 'id']);
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
    public function getIdPaymentMethod()
    {
        return $this->hasOne(TPaymentMethod::className(), ['id' => 'id_payment_method']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusPayment()
    {
        return $this->hasOne(TPaymentStatus::className(), ['id' => 'status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaypalTransaction() 
    { 
        return $this->hasOne(TPaypalTransaction::className(), ['payment_token' => 'token']); 
    }

    public function setPaymentStatus($status){
        $this->status = $status;
        $this->save();
        return true;
    }

    public function setPaymentMethod($id_payment_method){
        $this->id_payment_method = $id_payment_method;
        return true;
    }


}
