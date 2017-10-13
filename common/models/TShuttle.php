<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_pickup".
 *
 * @property string $id_booking
 * @property integer $id_location
 * @property integer $id_pickup_type
 * @property double $price
 * @property integer $id_time
 *
 * @property TShuttleLocation $idLocation
 * @property TShuttleType $idPickupType
 * @property TShuttlePrice $idTime
 * @property TBooking $idBooking
 */
class TShuttle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_shuttle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_booking', 'id_location'], 'required'],
            [['id_location', 'id_pickup_type', 'id_time'], 'integer'],
            [['price'], 'number'],
            [['id_booking'], 'string', 'max' => 5],
            [['id_location'], 'exist', 'skipOnError' => true, 'targetClass' => TShuttleLocation::className(), 'targetAttribute' => ['id_location' => 'id']],
            [['id_pickup_type'], 'exist', 'skipOnError' => true, 'targetClass' => TShuttleType::className(), 'targetAttribute' => ['id_pickup_type' => 'id']],
            [['id_time'], 'exist', 'skipOnError' => true, 'targetClass' => TShuttlePrice::className(), 'targetAttribute' => ['id_time' => 'id']],
            [['id_booking'], 'exist', 'skipOnError' => true, 'targetClass' => TBooking::className(), 'targetAttribute' => ['id_booking' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_booking' => Yii::t('app', 'Booking'),
            'id_location' => Yii::t('app', 'Location'),
            'id_pickup_type' => Yii::t('app', 'Pickup Type'),
            'price' => Yii::t('app', 'Price'),
            'id_time' => Yii::t('app', 'Id Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdLocation()
    {
        return $this->hasOne(TShuttleLocation::className(), ['id' => 'id_location']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPickupType()
    {
        return $this->hasOne(TShuttleType::className(), ['id' => 'id_pickup_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTime()
    {
        return $this->hasOne(TShuttlePrice::className(), ['id' => 'id_time']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdBooking()
    {
        return $this->hasOne(TBooking::className(), ['id' => 'id_booking']);
    }
}
