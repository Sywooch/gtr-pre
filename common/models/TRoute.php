<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_route".
 *
 * @property integer $id
 * @property integer $departure
 * @property integer $arrival
 *
 * @property THarbor $departure0
 * @property THarbor $arrival0
 * @property TTrip[] $tTrips
 */
class TRoute extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_route';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['departure', 'arrival'], 'required'],
            [['departure', 'arrival'], 'integer'],
            [['departure'], 'exist', 'skipOnError' => true, 'targetClass' => THarbor::className(), 'targetAttribute' => ['departure' => 'id']],
            [['arrival'], 'exist', 'skipOnError' => true, 'targetClass' => THarbor::className(), 'targetAttribute' => ['arrival' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'departure' => Yii::t('app', 'Departure'),
            'arrival' => Yii::t('app', 'Arrival'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartureHarbor()
    {
        return $this->hasOne(THarbor::className(), ['id' => 'departure']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArrivalHarbor()
    {
        return $this->hasOne(THarbor::className(), ['id' => 'arrival']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTTrips()
    {
        return $this->hasMany(TTrip::className(), ['id_route' => 'id']);
    }

    public function getTSeasonSets()
    {
        return $this->hasMany(TSeasonPriceSet::className(), ['id_route' => 'id']);
    }
}
