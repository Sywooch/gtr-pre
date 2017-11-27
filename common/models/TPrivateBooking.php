<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_private_booking".
 *
 * @property string $id
 * @property integer $id_payment
 * @property integer $id_status
 * @property double $amount
 * @property string $currency
 * @property integer $amount_idr
 * @property string $date_trip
 * @property string $datetime
 *
 * @property TKurs $currency0
 * @property TPayment $idPayment
 * @property TBookingStatus $idStatus
 */
class TPrivateBooking extends \yii\db\ActiveRecord
{
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
            [['id', 'id_payment', 'id_status', 'amount', 'currency', 'amount_idr', 'date_trip', 'datetime'], 'required'],
            [['id_payment', 'id_status', 'amount_idr'], 'integer'],
            [['amount'], 'number'],
            [['date_trip', 'datetime'], 'safe'],
            [['id'], 'string', 'max' => 6],
            [['currency'], 'string', 'max' => 5],
            [['currency'], 'exist', 'skipOnError' => true, 'targetClass' => TKurs::className(), 'targetAttribute' => ['currency' => 'currency']],
            [['id_payment'], 'exist', 'skipOnError' => true, 'targetClass' => TPayment::className(), 'targetAttribute' => ['id_payment' => 'id']],
            [['id_status'], 'exist', 'skipOnError' => true, 'targetClass' => TBookingStatus::className(), 'targetAttribute' => ['id_status' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_payment' => Yii::t('app', 'Id Payment'),
            'id_status' => Yii::t('app', 'Id Status'),
            'amount' => Yii::t('app', 'Amount'),
            'currency' => Yii::t('app', 'Currency'),
            'amount_idr' => Yii::t('app', 'Amount Idr'),
            'date_trip' => Yii::t('app', 'Date Trip'),
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
}
