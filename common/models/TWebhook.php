<?php

namespace common\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "t_webhook".
 *
 * @property string $id
 * @property integer $id_resource_type
 * @property integer $id_event
 * @property integer $id_status
 * @property string $description
 * @property double $amount
 * @property string $currency
 * @property string $id_paypal_transaction
 * @property string $id_parent_payment
 * @property string $paypal_time
 * @property string $datetime
 *
 * @property TPaypalStatus $idStatus
 * @property TKurs $currency0
 * @property TWebhookEvent $idEvent
 * @property TPaypalIntent $idResourceType
 */
class TWebhook extends \yii\db\ActiveRecord
{

    const PAYMENT_SALE_COMPLETED = 1;
    const PAYMENT_SALE_PENDING   = 2;
    //const USERNAME = ""
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_webhook';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_resource_type', 'id_event', 'id_status', 'description', 'amount', 'currency', 'id_paypal_transaction', 'id_parent_payment', 'paypal_time', 'datetime'], 'required'],
            [['id_resource_type', 'id_event', 'id_status'], 'integer'],
            [['amount'], 'number'],
            [['datetime'], 'safe'],
            [['id', 'id_parent_payment'], 'string', 'max' => 40],
            [['description'], 'string', 'max' => 100],
            [['currency'], 'string', 'max' => 5],
            [['id_paypal_transaction'], 'string', 'max' => 20],
            [['paypal_time'], 'string', 'max' => 25],
            [['id_paypal_transaction'], 'exist', 'skipOnError' => false, 'targetClass' => TPaypalTransaction::className(), 'targetAttribute' => ['id_paypal_transaction' => 'id']],
            [['id_status'], 'exist', 'skipOnError' => true, 'targetClass' => TPaypalStatus::className(), 'targetAttribute' => ['id_status' => 'id']],
            [['currency'], 'exist', 'skipOnError' => true, 'targetClass' => TKurs::className(), 'targetAttribute' => ['currency' => 'currency']],
            [['id_event'], 'exist', 'skipOnError' => true, 'targetClass' => TWebhookEvent::className(), 'targetAttribute' => ['id_event' => 'id']],
            [['id_resource_type'], 'exist', 'skipOnError' => true, 'targetClass' => TPaypalIntent::className(), 'targetAttribute' => ['id_resource_type' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_resource_type' => Yii::t('app', 'Resource Type'),
            'id_event' => Yii::t('app', 'Event'),
            'id_status' => Yii::t('app', 'Status'),
            'description' => Yii::t('app', 'Description'),
            'amount' => Yii::t('app', 'Amount'),
            'currency' => Yii::t('app', 'Currency'),
            'id_paypal_transaction' => Yii::t('app', 'Id Paypal Transaction'),
            'id_parent_payment' => Yii::t('app', 'Id Parent Payment'),
            'paypal_time' => Yii::t('app', 'Paypal Time'),
            'datetime' => Yii::t('app', 'Datetime'),
        ];
    }

    public function getPaypalTransaction()
    {
        return $this->hasMany(TPaypalTransaction::className(), ['id' => 'id_paypal_transaction']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdStatus()
    {
        return $this->hasOne(TPaypalStatus::className(), ['id' => 'id_status']);
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
    public function getIdEvent()
    {
        return $this->hasOne(TWebhookEvent::className(), ['id' => 'id_event']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdResourceType()
    {
        return $this->hasOne(TPaypalIntent::className(), ['id' => 'id_resource_type']);
    }

    public static function addWebHook(array $WebHookArray){
        if (($model = TWebhook::findOne($WebHookArray['id'])) === null) {
                    $modelWebHook                        = new TWebhook();
                    $modelWebHook->id                    = $WebHookArray['id'];
                    $modelWebHook->id_resource_type      = TPaypalIntent::checkIntent($WebHookArray['resource_type']);
                    $modelWebHook->id_event              = TWebhookEvent::checkEvent($WebHookArray['event_type']);
                    $modelWebHook->id_status             = TPaypalStatus::checkStatus($WebHookArray['resource']['state']);
                    $modelWebHook->description           = $WebHookArray['summary'];
                    $modelWebHook->amount                = $WebHookArray['resource']['amount']['total'];
                    $modelWebHook->currency              = $WebHookArray['resource']['amount']['currency'];
                    $modelWebHook->id_paypal_transaction = $WebHookArray['resource']['id'];
                    $modelWebHook->id_parent_payment     = $WebHookArray['resource']['parent_payment'];
                    $modelWebHook->paypal_time           = $WebHookArray['create_time'];
                    $modelWebHook->datetime              = date('Y-m-d H:i:s');
                    $modelWebHook->validate();
                    $modelWebHook->save(false);
                    return true;
        }else{
            return true;
        }
        
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($this->id_event == self::PAYMENT_SALE_COMPLETED || $this->id_event == self::PAYMENT_SALE_PENDING) {
            if (empty($this->paypalTransaction)) {
                $token = $this->requestToken();
                $paymentDetail = $this->requestPaymentDetail($token,$this->id_parent_payment);
                    $modelPaypalTransaction = TPaypalTransaction::addTransactionData($paymentDetail);
                    return true;
            }
        }else{
            return "Empty";
        }
    }

    public static function requestPaymentDetail($token,$parent_payment){
        try {
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.sandbox.paypal.com/v1/payments/payment/PAY-1U323187FR444474WLIPI3RI",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
            "authorization: Bearer ".$token."",
            "cache-control: no-cache",
            "content-type: application/json",
            "postman-token: 209203db-d4c0-6516-6e77-5a066d0b34c1"
            ),
            ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                if ($err) {
                  return $this->requestPaymentDetail();
                } else {
                  return Json::decode($response, $asArray = true);
                }
            } catch (Exception $e) {
                return $this->requestPaymentDetail();
            }
    }

    public static function requestToken(){
        try {
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.sandbox.paypal.com/v1/oauth2/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "grant_type=client_credentials",
            CURLOPT_HTTPHEADER => array(
            "authorization: Basic QVpvOHhfdmJoMHlFcXdiUmY2Yl9Ka1ZtQUFfRFBrTXdxOXVzNHl1V3NYMXVyclVtT2NDY3d1OU41dlh3azFtdXFrdktJVEJNcWpVOXdWUUs6RUhzekNYTnZUS3JPODllUVZYQ2tSWTBSOHN3S1hUNlhvS1hoTEctNDU1MlpFVDNFRW4xMjZvNi1qeWR5V3ZWYlRiaWY5ckQzc0tZdDM5VEI=",
            "cache-control: no-cache",
            "content-type: application/x-www-form-urlencoded",
            "postman-token: 9c9745ef-12a4-5c0d-c7d0-ac98262d5c72"
            ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
              return $this->requestToken();
            } else {
                $result = Json::decode($response, $asArray = true);
              return $result['access_token'];
            }
        } catch (Exception $e) {
            return $this->requestToken();
        }
    }
}
