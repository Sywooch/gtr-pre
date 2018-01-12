<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_bank_transfer_transaction".
 *
 * @property string $id
 * @property string $payment_token
 * @property integer $id_status
 * @property string $va_number
 * @property integer $id_fraud_status
 * @property string $datetime
 *
 * @property TFraudStatus $idFraudStatus
 * @property TPayment $paymentToken
 * @property TBankTransferStatus $idStatus
 */
class TBankTransferTransaction extends \yii\db\ActiveRecord
{
    const STATUS_AUTHORIZE          = 1; 
    const STATUS_CAPTURE            = 2;
    const STATUS_SETTLEMENT         = 3;
    const STATUS_DENY               = 4;
    const STATUS_PENDING            = 5;
    const STATUS_CANCEL             = 6;
    const STATUS_PARTIAL_REFUND     = 7;
    const STATUS_CHARGEBACK         = 9;
    const STATUS_PARTIAL_CHARGEBACK = 10;
    const STATUS_EXPIRED            = 11;
    const STATUS_FAILURE            = 12;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_bank_transfer_transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'payment_token', 'id_status', 'va_number', 'id_fraud_status', 'datetime','status_code'], 'required'],
            [['id_status', 'id_fraud_status','status_code'], 'integer'],
            [['datetime'], 'safe'],
            [['id'], 'string', 'max' => 100],
            [['payment_token'], 'string', 'max' => 25],
            [['va_number'], 'string', 'max' => 255],
            [['id_fraud_status'], 'exist', 'skipOnError' => true, 'targetClass' => TFraudStatus::className(), 'targetAttribute' => ['id_fraud_status' => 'id']],
            [['payment_token'], 'exist', 'skipOnError' => true, 'targetClass' => TPayment::className(), 'targetAttribute' => ['payment_token' => 'token']],
            [['id_status'], 'exist', 'skipOnError' => true, 'targetClass' => TBankTransferStatus::className(), 'targetAttribute' => ['id_status' => 'id']],
            [['status_code'], 'exist', 'skipOnError' => true, 'targetClass' => TBankTransferStatus::className(), 'targetAttribute' => ['status_code' => 'status_code']],
        ];
    }

    public function afterSave($insert, $changedAttributes){
        if ($this->id_status == self::STATUS_PENDING) {
            $statusPayment = TPayment::STATUS_PENDING; //PENDING
            $statusBooking = TBooking::STATUS_UNPAID; //UNPAID
        }elseif ($this->id_status == self::STATUS_SETTLEMENT) {
            $statusPayment = TPayment::STATUS_CONFIRM_RECEIVED; //CONFIRM RECEIVED
            $statusBooking = TBooking::STATUS_PAID; //PAID
        }elseif ($this->id_status == self::STATUS_EXPIRED) {
            $statusPayment = TPayment::STATUS_EXPIRED;
            $statusBooking = TBooking::STATUS_EXPIRED;
        }elseif ($this->id_status == self::STATUS_CANCEL) {
            $statusPayment = TPayment::STATUS_INVALID;
            $statusBooking = TBooking::STATUS_INVALID;
        }
        $modelPayment         = $this->paymentToken;
        $modelPayment->setPaymentBookingStatus($statusPayment,$statusBooking);
        $modelPayment->save(false);
        return true;
        
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'payment_token' => 'Payment Token',
            'id_status' => 'Id Status',
            'va_number' => 'Va Number',
            'id_fraud_status' => 'Id Fraud Status',
            'datetime' => 'Datetime',
        ];
    }

    public static function addData(array $data, $payment_method){
        $modelBank                = new TBankTransferTransaction();
        $modelBank->id            = $data['transaction_id'];
        $modelBank->payment_token = $data['order_id'];
        $modelBank->status_code   = $data['status_code'];
        $modelBank->id_status     = TBankTransferStatus::getStatus($data['transaction_status']);
        //BCA VA
        if ($payment_method == 2) {
            $modelBank->va_number = $data['va_numbers'][0]['va_number'];
        //PERMATA VA
        }elseif ($payment_method == 3) {
            $modelBank->va_number = $data['permata_va_number'];
        //MANDIRI BILL PAYMENT
        }elseif($payment_method == 4){
            $modelBank->va_number = $data['bill_key'];

        }
        
        $modelBank->id_fraud_status = TFraudStatus::getFraudStatus($data['fraud_status']);
        $modelBank->datetime = date('Y-m-d H:i:s');
       // if ($modelBank->validate()) {
            $modelBank->save(false);
            return true;
       // }
    }

    public static function updateData(array $data){
        $modelBank            = TBankTransferTransaction::findOne($data['transaction_id']);
        $modelBank->id_status = TBankTransferStatus::getStatus($data['transaction_status']);
        $modelBank->datetime  = date('Y-m-d H:i:s');
        $modelBank->save(false);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdFraudStatus()
    {
        return $this->hasOne(TFraudStatus::className(), ['id' => 'id_fraud_status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentToken()
    {
        return $this->hasOne(TPayment::className(), ['token' => 'payment_token']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdStatus()
    {
        return $this->hasOne(TBankTransferStatus::className(), ['id' => 'id_status']);
    }

    public function getStatusCode()
    {
        return $this->hasOne(TBankTransferStatusCode::className(), ['status_code' => 'status_code']);
    }
}
