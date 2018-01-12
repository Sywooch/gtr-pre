<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_payment_method".
 *
 * @property integer $id
 * @property string $method
 * @property integer $id_status
 *
 * @property TPayment[] $tPayments
 * @property TStatusTrip $idStatus
 */
class TPaymentMethod extends \yii\db\ActiveRecord
{
    const STATUS_ON = 1;
    const STATUS_OFF = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_payment_method';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['method', 'id_status'], 'required'],
            [['id_status'], 'integer'],
            [['id_status'],'in','range'=>[self::STATUS_ON, self::STATUS_OFF]],
            [['method'], 'string', 'max' => 50],
            [['id_status'], 'exist', 'skipOnError' => true, 'targetClass' => TStatusTrip::className(), 'targetAttribute' => ['id_status' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'method' => 'Method',
            'id_status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTPayments()
    {
        return $this->hasMany(TPayment::className(), ['id_payment_method' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdStatus()
    {
        return $this->hasOne(TStatusTrip::className(), ['id' => 'id_status']);
    }
}
