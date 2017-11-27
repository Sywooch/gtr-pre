<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_private_trip".
 *
 * @property integer $id
 * @property integer $id_boat
 * @property integer $id_route
 * @property integer $min_price
 * @property integer $max_person
 * @property integer $person_price
 * @property integer $min_time
 * @property integer $max_time
 * @property string $datetime
 *
 * @property TTime $maxTime
 * @property TTime $minTime
 * @property TRoute $idRoute
 */
class TPrivateTrip extends \yii\db\ActiveRecord
{
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
            [['id_boat', 'id_route', 'min_price', 'max_person', 'person_price', 'min_time', 'max_time', 'datetime'], 'required'],
            [['id_boat', 'id_route', 'min_price', 'max_person', 'person_price', 'min_time', 'max_time'], 'integer'],
            [['datetime'], 'safe'],
            [['max_time'], 'exist', 'skipOnError' => true, 'targetClass' => TTime::className(), 'targetAttribute' => ['max_time' => 'id']],
            [['min_time'], 'exist', 'skipOnError' => true, 'targetClass' => TTime::className(), 'targetAttribute' => ['min_time' => 'id']],
            [['id_route'], 'exist', 'skipOnError' => true, 'targetClass' => TRoute::className(), 'targetAttribute' => ['id_route' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_boat' => Yii::t('app', 'Id Boat'),
            'id_route' => Yii::t('app', 'Id Route'),
            'min_price' => Yii::t('app', 'Min Price'),
            'max_person' => Yii::t('app', 'Max Person'),
            'person_price' => Yii::t('app', 'Person Price'),
            'min_time' => Yii::t('app', 'Min Time'),
            'max_time' => Yii::t('app', 'Max Time'),
            'datetime' => Yii::t('app', 'Datetime'),
        ];
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
        return $this->hasOne(TRoute::className(), ['id' => 'id_route']);
    }
}
