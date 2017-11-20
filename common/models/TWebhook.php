<?php

namespace common\models;

use Yii;

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
            [['id', 'id_resource_type', 'id_event', 'id_status', 'description', 'amount', 'currency', 'id_paypal_transaction', 'paypal_time', 'datetime'], 'required'],
            [['id_resource_type', 'id_event', 'id_status'], 'integer'],
            [['amount'], 'number'],
            [['datetime'], 'safe'],
            [['id'], 'string', 'max' => 40],
            [['description'], 'string', 'max' => 100],
            [['currency'], 'string', 'max' => 5],
            [['id_paypal_transaction'], 'string', 'max' => 20],
            [['paypal_time'], 'string', 'max' => 25],
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
            'id_resource_type' => Yii::t('app', 'Id Resource Type'),
            'id_event' => Yii::t('app', 'Id Event'),
            'id_status' => Yii::t('app', 'Id Status'),
            'description' => Yii::t('app', 'Description'),
            'amount' => Yii::t('app', 'Amount'),
            'currency' => Yii::t('app', 'Currency'),
            'id_paypal_transaction' => Yii::t('app', 'Id Paypal Transaction'),
            'paypal_time' => Yii::t('app', 'Paypal Time'),
            'datetime' => Yii::t('app', 'Datetime'),
        ];
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
}
