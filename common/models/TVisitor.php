<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_visitor".
 *
 * @property integer $id
 * @property string $ip
 * @property string $id_country
 * @property string $region
 * @property string $city
 * @property integer $id_timezone
 * @property string $latitude
 * @property string $longitude
 * @property string $url
 * @property string $user_agent
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property TCountry $idCountry
 * @property TTimezone $idTimezone
 */
class TVisitor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_visitor';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip', 'id_country', 'region', 'city', 'id_timezone', 'latitude', 'longitude', 'url', 'user_agent'], 'required'],
            [['id_timezone'], 'integer'],
            [['created_at','updated_at'],'safe'],
            [['url', 'user_agent'], 'string'],
            [['ip'], 'string', 'max' => 20],
            [['id_country'], 'string', 'max' => 2],
            [['region', 'city'], 'string', 'max' => 50],
            [['latitude', 'longitude'], 'string', 'max' => 25],
            [['id_country'], 'exist', 'skipOnError' => true, 'targetClass' => TCountry::className(), 'targetAttribute' => ['id_country' => 'id']],
            [['id_timezone'], 'exist', 'skipOnError' => true, 'targetClass' => TTimezone::className(), 'targetAttribute' => ['id_timezone' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ip' => Yii::t('app', 'Ip'),
            'id_country' => Yii::t('app', 'Id Country'),
            'region' => Yii::t('app', 'Region'),
            'city' => Yii::t('app', 'City'),
            'id_timezone' => Yii::t('app', 'Id Timezone'),
            'latitude' => Yii::t('app', 'Latitude'),
            'longitude' => Yii::t('app', 'Longitude'),
            'url' => Yii::t('app', 'Url'),
            'user_agent' => Yii::t('app', 'User Agent'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCountry()
    {
        return $this->hasOne(TCountry::className(), ['id' => 'id_country']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTimezone()
    {
        return $this->hasOne(TTimezone::className(), ['id' => 'id_timezone']);
    }

    public function findTimeZone($time_zone){
        if (($modelTimezone = TTimezone::find()->where(['timezone'=>$time_zone])->one()) != null) {
            return $modelTimezone->id;
        }else{
            return '0';
        }
    }
}
