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
 * @property string $paypal_time
 * @property string $datetime
 *
 * @property TPaypalIntent $idIntent
 * @property TPaypalPayer $idPayer
 * @property TPaypalStatus $idStatus
 */
class TPaypalTransaction extends \yii\db\ActiveRecord
{
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
            [['id', 'id_payer', 'amount', 'currency', 'description', 'id_intent', 'id_status', 'paypal_time', 'datetime'], 'required'],
            [['amount'], 'number'],
            [['id_intent', 'id_status'], 'integer'],
            [['datetime'], 'safe'],
            [['id'], 'string', 'max' => 20],
            [['id_payer'], 'string', 'max' => 15],
            [['currency'], 'string', 'max' => 5],
            [['description'], 'string', 'max' => 100],
            [['paypal_time'], 'string', 'max' => 25],
            [['id_intent'], 'exist', 'skipOnError' => true, 'targetClass' => TPaypalIntent::className(), 'targetAttribute' => ['id_intent' => 'id']],
            [['id_payer'], 'exist', 'skipOnError' => true, 'targetClass' => TPaypalPayer::className(), 'targetAttribute' => ['id_payer' => 'id']],
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
            'paypal_time' => Yii::t('app', 'Paypal Time'),
            'datetime' => Yii::t('app', 'Datetime'),
        ];
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
    public function getIdStatus()
    {
        return $this->hasOne(TPaypalStatus::className(), ['id' => 'id_status']);
    }
}
