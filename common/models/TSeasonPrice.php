<?php

namespace common\models;

use Yii;
use yii\db\Expression;
/**
 * This is the model class for table "t_season_price".
 *
 * @property integer $id
 * @property integer $id_season_type
 * @property integer $id_trip
 * @property integer $adult_price
 * @property integer $child_price
 * @property integer $infant_price
 * @property string $start_date
 * @property string $end_date
 * @property string $datetime
 *
 * @property TTrip $idTrip
 * @property TSeasonType $idSeasonType
 */
class TSeasonPrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_season_price';
    }

  // public $now = date('Y-m-d H:i:00');
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_season_type', 'id_trip', 'adult_price', 'child_price', 'infant_price', 'start_date', 'end_date'], 'required'],
            ['datetime', 'default', 'value' => date('Y-m-d H:i:00')],
            [['id_season_type', 'id_trip', 'adult_price', 'child_price', 'infant_price'], 'integer'],
            [['start_date', 'end_date', 'datetime'], 'safe'],
            [['id_trip'], 'exist', 'skipOnError' => true, 'targetClass' => TTrip::className(), 'targetAttribute' => ['id_trip' => 'id']],
            [['id_season_type'], 'exist', 'skipOnError' => true, 'targetClass' => TSeasonType::className(), 'targetAttribute' => ['id_season_type' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_season_type' => Yii::t('app', 'Season Type'),
            'id_trip' => Yii::t('app', 'Trip'),
            'adult_price' => Yii::t('app', 'Adult Price'),
            'child_price' => Yii::t('app', 'Child Price'),
            'infant_price' => Yii::t('app', 'Infant Price'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
            'datetime' => Yii::t('app', 'Datetime'),
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
    public function getIdSeasonType()
    {
        return $this->hasOne(TSeasonType::className(), ['id' => 'id_season_type']);
    }
}
