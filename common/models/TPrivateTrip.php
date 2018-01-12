<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_private_trip".
 *
 * @property integer $id
 * @property integer $id_route
 * @property integer $min_price
 * @property integer $max_person
 * @property integer $person_price
 * @property integer $min_time
 * @property integer $max_time
 * @property integer $id_est_time
 * @property string $description
 * @property integer $id_status
 * @property string $datetime
 *
 * @property TPrivateCart[] $tPrivateCarts
 * @property TEstTime $idEstTime
 * @property TTime $maxTime
 * @property TTime $minTime
 * @property TPrivateRoute $idRoute
 * @property TStatusTrip $idStatus
 */
class TPrivateTrip extends \yii\db\ActiveRecord
{
    const STATUS_ON    = 1;
    const STATUS_OFF   = 2;
    const STATUS_BLOCK = 3;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_private_trip';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_route', 'min_price', 'max_person', 'person_price', 'min_time', 'max_time','id_est_time'], 'required'],
            [['id_route', 'min_price', 'max_person', 'person_price', 'min_time', 'max_time', 'id_status','id_est_time'], 'integer'],
            [['description'], 'string'],
            [['min_time'], 'compare', 'compareAttribute' => 'max_time','operator' => '<'], 
            [['max_time'], 'compare', 'compareAttribute' => 'min_time','operator' => '>'], 
            [['id_status'],'in','range'=>[self::STATUS_ON,self::STATUS_OFF,self::STATUS_BLOCK]],
            [['id_status'],'default','value'=>self::STATUS_ON],
            [['datetime'],'default','value'=>date('Y-m-d H:i:s')],
            [['datetime'],'default','value'=>NULL],
            [['datetime'], 'safe'],
            [['id_est_time'], 'exist', 'skipOnError' => true, 'targetClass' => TEstTime::className(), 'targetAttribute' => ['id_est_time' => 'id']],
            [['max_time'], 'exist', 'skipOnError' => true, 'targetClass' => TTime::className(), 'targetAttribute' => ['max_time' => 'id']],
            [['min_time'], 'exist', 'skipOnError' => true, 'targetClass' => TTime::className(), 'targetAttribute' => ['min_time' => 'id']],
            [['id_route'], 'exist', 'skipOnError' => true, 'targetClass' => TPrivateRoute::className(), 'targetAttribute' => ['id_route' => 'id']],
            [['id_status'], 'exist', 'skipOnError' => true, 'targetClass' => TStatusTrip::className(), 'targetAttribute' => ['id_status' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_route' => Yii::t('app', 'Route'),
            'min_price' => Yii::t('app', 'Min Price'),
            'max_person' => Yii::t('app', 'Max Person'),
            'person_price' => Yii::t('app', 'Person Price'),
            'min_time' => Yii::t('app', 'Min Time'),
            'max_time' => Yii::t('app', 'Max Time'),
            'id_est_time' => Yii::t('app', 'Est Time'),
            'description' => Yii::t('app', 'Description'),
            'id_status' => Yii::t('app', 'Status'),
            'datetime' => Yii::t('app', 'Datetime'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTPrivateCarts()
    {
        return $this->hasMany(TPrivateCart::className(), ['id_trip' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEstTime()
    {
        return $this->hasOne(TEstTime::className(), ['id' => 'id_est_time']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaxTime()
    {
        return $this->hasOne(TTime::className(), ['id' => 'max_time']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMinTime()
    {
        return $this->hasOne(TTime::className(), ['id' => 'min_time']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdRoute()
    {
        return $this->hasOne(TPrivateRoute::className(), ['id' => 'id_route']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdStatus()
    {
        return $this->hasOne(TStatusTrip::className(), ['id' => 'id_status']);
    }

    public static function getArrayPrivateTrip($id_route){
       return TPrivateTrip::find()->joinWith(['idEstTime','maxTime as maxTime','minTime','idRoute.fromRoute as fromRoute','idRoute.toRoute'])->where(['id_route'=>$id_route,'id_status'=>self::STATUS_ON])->asArray()->one();
    }
    
}
