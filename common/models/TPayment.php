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
 * @property string $currency
 * @property integer $exchange
 * @property double $send_amount
 * @property string $token
 * @property integer $status
 * @property string $exp
 * @property string $update_at
 *
 * @property TBooking[] $tBookings
 * @property TKurs $currency0
 * @property TPaymentMethod $idPaymentMethod
 */
class TPayment extends \yii\db\ActiveRecord
{
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
            [['id_payment_method'], 'required'],
            [['id_payment_method', 'exchange', 'status'], 'integer'],
            [['total_payment','total_payment_idr', 'send_amount'], 'number'],
            [['exp', 'update_at'], 'safe'],
            [['name', 'email'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 20],
            [['currency'], 'string', 'max' => 5],
            [['token'], 'string', 'max' => 25],
            [['token'], 'unique'],
            [['currency'], 'exist', 'skipOnError' => true, 'targetClass' => TKurs::className(), 'targetAttribute' => ['currency' => 'currency']],
            [['id_payment_method'], 'exist', 'skipOnError' => true, 'targetClass' => TPaymentMethod::className(), 'targetAttribute' => ['id_payment_method' => 'id']],
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
}
