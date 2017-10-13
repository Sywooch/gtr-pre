<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_trip".
 *
 * @property integer $id
 * @property integer $id_boat
 * @property integer $id_route
 * @property string $date
 * @property string $dept_time
 * @property string $est_time
 * @property string $description
 * @property integer $status
 * @property string $datetime
 *
 * @property TAvaibility[] $tAvaibilities
 * @property TBooking[] $tBookings
 * @property TSeasonPrice[] $tSeasonPrices
 * @property TSpecialPrice[] $tSpecialPrices
 * @property TBoat $idBoat
 * @property TRoute $idRoute
 * @property TStatusTrip $status0
 */
class TTrip extends \yii\db\ActiveRecord
{
    public $id_company;
    const STATUS_ON = 1;
    const STATUS_OFF = 2;
    public $startDate;
    public $endDate;
    public $template;
 
 
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_trip';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_boat', 'id_route', 'date','id_est_time'], 'required'],
            [['id_boat', 'id_route', 'status','template','id_est_time','adult_price','child_price','id_season'], 'integer'],
            [['date', 'dept_time', 'datetime','startDate','endDate'], 'safe'],
            ['status', 'default', 'value' => self::STATUS_ON],
            ['status', 'in', 'range' => [self::STATUS_ON, self::STATUS_OFF]],
            
            [['description'], 'string', 'max' => 100],
            [['id_boat'], 'exist', 'skipOnError' => true, 'targetClass' => TBoat::className(), 'targetAttribute' => ['id_boat' => 'id']],
            [['id_route'], 'exist', 'skipOnError' => true, 'targetClass' => TRoute::className(), 'targetAttribute' => ['id_route' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => TStatusTrip::className(), 'targetAttribute' => ['status' => 'id']],
            [['id_season'], 'exist', 'skipOnError' => true, 'targetClass' => TSeasonPriceSet::className(), 'targetAttribute' => ['id_season' => 'id']],
             [['id_est_time'], 'exist', 'skipOnError' => true, 'targetClass' => TEstTime::className(), 'targetAttribute' => ['id_est_time' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_boat' => Yii::t('app', 'Boat'),
            'id_company'=>Yii::t('app', 'Company'),
            'id_route' => Yii::t('app', 'Route'),
            'date' => Yii::t('app', 'Dept Date'),
            'dept_time' => Yii::t('app', 'Dept Time'),
            'id_est_time' => Yii::t('app', 'Est Time'),
            'description' => Yii::t('app', 'Description'),
            'status' => Yii::t('app', 'Status'),
            'id_season' => Yii::t('app', 'Season'),
            'datetime' => Yii::t('app', 'Datetime'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTAvaibility()
    {
        return $this->hasOne(TAvaibility::className(), ['id_trip' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTBookings()
    {
        return $this->hasMany(TBooking::className(), ['id_trip' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTSeasonPrices()
    {
        return $this->hasMany(TSeasonPrice::className(), ['id_trip' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTSpecialPrices()
    {
        return $this->hasMany(TSpecialPrice::className(), ['id_trip' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdBoat()
    {
        return $this->hasOne(TBoat::className(), ['id' => 'id_boat']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdRoute()
    {
        return $this->hasOne(TRoute::className(), ['id' => 'id_route']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(TStatusTrip::className(), ['id' => 'status']);
    }
    public function getIdSeason()
    {
        return $this->hasOne(TSeasonPriceSet::className(), ['id' => 'id_season']);
    }
}
