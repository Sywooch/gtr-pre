<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_time".
 *
 * @property integer $id
 * @property string $time
 *
 * @property TPrivateTrip[] $tPrivateTrips
 * @property TPrivateTrip[] $tPrivateTrips0
 */
class TTime extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_time';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time'], 'required'],
            [['time'], 'string', 'max' => 5],
            [['time'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'time' => Yii::t('app', 'Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTPrivateTrips()
    {
        return $this->hasMany(TPrivateTrip::className(), ['max_time' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTPrivateTrips0()
    {
        return $this->hasMany(TPrivateTrip::className(), ['min_time' => 'id']);
    }
}
