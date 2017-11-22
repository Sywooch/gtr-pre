<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_paypal_transaction".
 *
 * @property string $id
 * @property string $id_payer
 * @property double $amount
 * @property string $currency
 * @property string $description
 * @property integer $id_intent
 * @property integer $id_status
 * @property string $payment_token
 * @property string $paypal_time
 * @property string $datetime
 *
 * @property TKurs $currency0
 * @property TPaypalIntent $idIntent
 * @property TPaypalPayer $idPayer
 * @property TPayment $paymentToken
 * @property TPaypalStatus $idStatus
 */
class TPaypalTransaction extends \yii\db\ActiveRecord
{
  const EVENT_SALE_COMPLETED = 1;
  const EVENT_SALE_PENDING   = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_paypal_transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_payer', 'amount', 'currency', 'description', 'id_intent', 'id_status', 'payment_token', 'paypal_time', 'datetime'], 'required'],
            [['amount'], 'number'],
            [['id_intent', 'id_status'], 'integer'],
            [['datetime'], 'safe'],
            [['id'], 'string', 'max' => 20],
            [['id_payer'], 'string', 'max' => 15],
            [['currency'], 'string', 'max' => 5],
            [['description'], 'string', 'max' => 100],
            [['payment_token', 'paypal_time'], 'string', 'max' => 25],
            [['payment_token'], 'unique'],
            [['currency'], 'exist', 'skipOnError' => true, 'targetClass' => TKurs::className(), 'targetAttribute' => ['currency' => 'currency']],
            [['id_intent'], 'exist', 'skipOnError' => true, 'targetClass' => TPaypalIntent::className(), 'targetAttribute' => ['id_intent' => 'id']],
            [['id_payer'], 'exist', 'skipOnError' => true, 'targetClass' => TPaypalPayer::className(), 'targetAttribute' => ['id_payer' => 'id']],
            [['payment_token'], 'exist', 'skipOnError' => true, 'targetClass' => TPayment::className(), 'targetAttribute' => ['payment_token' => 'token']],
            [['id_status'], 'exist', 'skipOnError' => true, 'targetClass' => TPaypalStatus::className(), 'targetAttribute' => ['id_status' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_payer' => Yii::t('app', 'Id Payer'),
            'amount' => Yii::t('app', 'Amount'),
            'currency' => Yii::t('app', 'Currency'),
            'description' => Yii::t('app', 'Description'),
            'id_intent' => Yii::t('app', 'Id Intent'),
            'id_status' => Yii::t('app', 'Id Status'),
            'payment_token' => Yii::t('app', 'Payment Token'),
            'paypal_time' => Yii::t('app', 'Paypal Time'),
            'datetime' => Yii::t('app', 'Datetime'),
        ];
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
    public function getIdIntent()
    {
        return $this->hasOne(TPaypalIntent::className(), ['id' => 'id_intent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPayer()
    {
        return $this->hasOne(TPaypalPayer::className(), ['id' => 'id_payer']);
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
        return $this->hasOne(TPaypalStatus::className(), ['id' => 'id_status']);
    }

    public function getTWebhook()
    {
        return $this->hasOne(TWebhook::className(), ['id_paypal_transaction' => 'id']);
    }


    public function afterSave($insert, $changedAttributes)
    {
            $modelpembayaranPaypal = $this->paymentToken;
            $modelBooking          = $this->paymentToken->tBookings;
            $modelWebHook          = $this->tWebhook;
            if ($modelWebHook->id_event == $modelWebHook::PAYMENT_SALE_COMPLETED) {

               $statusPayment = $modelpembayaranPaypal::STATUS_CONFIRM_RECEIVED;
               $statusBooking = $modelpembayaranPaypal::STATUS_PARTIAL_REFUND; //SUKSES

            }elseif($modelWebHook->id_event == $modelWebHook::PAYMENT_SALE_PENDING){

               $statusPayment = $modelpembayaranPaypal::STATUS_CONFIRM_NOT_RECEIVED;
               $statusBooking = $modelpembayaranPaypal::STATUS_CONFIRM_RECEIVED; //PAID

            }else{
              return true;
            }
            foreach ($modelBooking as $key => $valBooking) {
                  $valBooking->id_status = $statusBooking;
                  $valBooking->validate();
                  $valBooking->save(false);
                 }
                 $modelpembayaranPaypal->id_payment_method = $modelpembayaranPaypal::STATUS_UNCONFIRMED; //PAYPAL
                 $modelpembayaranPaypal->status            = $statusPayment;
                 $modelpembayaranPaypal->validate();
                 $modelpembayaranPaypal->save(false);
                 $modelQueue                               = TMailQueue::addTicketQueue($modelpembayaranPaypal->id);
    }

    public function addTransactionData(array $data){
        $arrayTransaction                          = $data['transactions'][0]['related_resources'][0]['sale'];
        if (($modelPaypalTransaction               = TPaypalTransaction::findOne($arrayTransaction['id'])) === null) {
            $PayerId                               = TPaypalPayer::checkPayer($data['payer']);
            $modelPaypalTransaction                = new TPaypalTransaction();
            $modelPaypalTransaction->id            = $arrayTransaction['id'];
            $modelPaypalTransaction->id_payer      = $PayerId;
            $modelPaypalTransaction->amount        = $arrayTransaction['amount']['total'];
            $modelPaypalTransaction->currency      = $arrayTransaction['amount']['currency'];
            $modelPaypalTransaction->description   = $data['transactions'][0]['item_list']['items'][0]['name'];
            $modelPaypalTransaction->id_intent     = TPaypalIntent::checkIntent($data['intent']);
            $modelPaypalTransaction->id_status     = TPaypalStatus::checkStatus($arrayTransaction['state']);
            $modelPaypalTransaction->payment_token = $data['transactions'][0]['item_list']['items'][0]['description'];
            $modelPaypalTransaction->paypal_time   = $data['create_time'];
            $modelPaypalTransaction->datetime      = date('Y-m-d H:i:s');
            $modelPaypalTransaction->save(false);
            return $modelPaypalTransaction->id;
        }else{
            return $modelPaypalTransaction->id;
        }

        
    }
}
