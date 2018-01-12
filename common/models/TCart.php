<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_cart".
 *
 * @property integer $id
 * @property string $session_key
 * @property integer $id_trip
 * @property integer $adult
 * @property integer $child
 * @property integer $infant
 * @property string $currency
 * @property integer $exchange
 * @property string $start_time
 * @property string $expired_time
 *
 * @property TTrip $idTrip
 * @property TKurs $currency0
 */
class TCart extends \yii\db\ActiveRecord
{
    const TYPE_RETURN = 2;
    const TYPE_ONE_WAY = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_cart';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['session_key', 'id_trip', 'adult', 'child', 'infant', 'currency', 'exchange','type'], 'required'],
            [['id_trip', 'adult', 'child', 'infant', 'exchange','type'], 'integer'],
            ['type', 'in', 'range' => [self::TYPE_ONE_WAY,self::TYPE_RETURN]],
            [['start_time', 'expired_time'], 'safe'],
            [['session_key'], 'string', 'max' => 25],
            [['currency'], 'string', 'max' => 5],
            [['id_trip'], 'exist', 'skipOnError' => true, 'targetClass' => TTrip::className(), 'targetAttribute' => ['id_trip' => 'id']],
            [['currency'], 'exist', 'skipOnError' => true, 'targetClass' => TKurs::className(), 'targetAttribute' => ['currency' => 'currency']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'session_key' => Yii::t('app', 'Session Key'),
            'id_trip' => Yii::t('app', 'Id Trip'),
            'adult' => Yii::t('app', 'Adult'),
            'child' => Yii::t('app', 'Child'),
            'infant' => Yii::t('app', 'Infant'),
            'currency' => Yii::t('app', 'Currency'),
            'exchange' => Yii::t('app', 'Exchange'),
            'start_time' => Yii::t('app', 'Start Time'),
            'expired_time' => Yii::t('app', 'Expired Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTrip()
    {
        return $this->hasOne(TTrip::className(), ['id' => 'id_trip']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCurrency()
    {
        return $this->hasOne(TKurs::className(), ['currency' => 'currency']);
    }
}
