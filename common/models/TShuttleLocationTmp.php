<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_shuttle_location_tmp".
 *
 * @property integer $id
 * @property string $id_booking
 * @property string $type
 * @property integer $id_area
 * @property string $location_name
 * @property string $address
 * @property string $phone
 * @property integer $datetime
 * @property integer $author
 *
 * @property TBooking $idBooking
 * @property TShuttleArea $idArea
 */
class TShuttleLocationTmp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_shuttle_location_tmp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_booking', 'type', 'id_area', 'location_name', 'address'], 'required'],
            [['id_area', 'datetime', 'author'], 'integer'],
            [['location_name', 'address'], 'string'],
            [['id_booking'], 'string', 'max' => 6],
            [['type'], 'string', 'max' => 10],
            [['phone'], 'string', 'max' => 15],
            [['id_booking'], 'exist', 'skipOnError' => true, 'targetClass' => TBooking::className(), 'targetAttribute' => ['id_booking' => 'id']],
            [['id_area'], 'exist', 'skipOnError' => true, 'targetClass' => TShuttleArea::className(), 'targetAttribute' => ['id_area' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_booking' => Yii::t('app', 'Id Booking'),
            'type' => Yii::t('app', 'Type'),
            'id_area' => Yii::t('app', 'Id Area'),
            'location_name' => Yii::t('app', 'Location Name'),
            'address' => Yii::t('app', 'Address'),
            'phone' => Yii::t('app', 'Phone'),
            'datetime' => Yii::t('app', 'Datetime'),
            'author' => Yii::t('app', 'Author'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdBooking()
    {
        return $this->hasOne(TBooking::className(), ['id' => 'id_booking']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdArea()
    {
        return $this->hasOne(TShuttleArea::className(), ['id' => 'id_area']);
    }
}
