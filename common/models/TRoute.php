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
    const FROM_BALI = 1;
    const TO_BALI   = 2;
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

    public static function getBaliArrayRoute($from,$toRoute, $type = null)
    {
        
        // groupPort Bali to something
        if ($type == self::FROM_BALI) {
            $where1 = 't_route.departure';
            $where2 = 't_route.arrival';
            $ports = explode('_', $from);
            $andWhereValue = $toRoute;
        // something to bali groupPort Bali
        }elseif ($type == self::TO_BALI) {
            $where1 = 't_route.arrival';
            $where2 = 't_route.departure';
            $ports = explode('_', $toRoute);
            $andWhereValue = $from;
        }
        $groupPort[] = "OR";
        foreach($ports as $port){
             $groupPort[] = ['=',$where1,$port];         
       }

        $modelRoute = TRoute::find()
        ->joinWith(['departureHarbor as DeparturePort'])
        ->where($groupPort)
        ->andWhere([$where2=>$andWhereValue])
        ->asArray()->all();
        return $modelRoute;

        // ->joinWith(['departureHarbor as DeparturePort','arrivalHarbor as ArriivalHarbor','departureHarbor.idIsland as departureISland','arrivalHarbor.idIsland as ArrivalIsland'])
    }
}
