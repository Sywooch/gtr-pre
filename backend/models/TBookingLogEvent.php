<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "t_booking_log_event".
 *
 * @property integer $id
 * @property string $event
 *
 * @property TBookingLog[] $tBookingLogs
 */
class TBookingLogEvent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_booking_log_event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event'], 'required'],
            [['event'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'event' => Yii::t('app', 'Event'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTBookingLogs()
    {
        return $this->hasMany(TBookingLog::className(), ['id_event' => 'id']);
    }
}
