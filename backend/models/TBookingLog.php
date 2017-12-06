<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "t_booking_log".
 *
 * @property integer $id
 * @property string $id_booking
 * @property integer $id_user
 * @property integer $id_event
 * @property string $datetime
 *
 * @property TBooking $idBooking
 * @property TBookingLogEvent $idEvent
 * @property User $idUser
 */
class TBookingLog extends \yii\db\ActiveRecord
{
    const EVENT_CONFIRM    = 1;
    const EVENT_REJECT     = 2;
    const EVENT_READ_CHECK = 3;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_booking_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_booking', 'id_event','datetime'], 'required'],
            [['id_user', 'id_event'], 'integer'],
            [['datetime'], 'safe'],
            [['id_event'],'in','range'=>[self::EVENT_CONFIRM,self::EVENT_REJECT,self::EVENT_READ_CHECK]],
            [['id_booking'], 'string', 'max' => 6],
            [['id_booking'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\TBooking::className(), 'targetAttribute' => ['id_booking' => 'id']],
            [['id_event'], 'exist', 'skipOnError' => true, 'targetClass' => TBookingLogEvent::className(), 'targetAttribute' => ['id_event' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_booking' => Yii::t('app', 'id Booking'),
            'id_user' => Yii::t('app', 'User'),
            'id_event' => Yii::t('app', 'Event'),
            'datetime' => Yii::t('app', 'Datetime'),
        ];
    }

    public static function addLog($id_booking,$id_event){
        $modelLog             = new TBookingLog();
        $modelLog->id_booking = $id_booking;
        $modelLog->id_event   = $id_event;
        $modelLog->id_user    = Yii::$app->user->identity->id;
        $modelLog->datetime   = date('Y-m-d H:i:s');
        if ($modelLog->id_event == self::EVENT_CONFIRM) {
            $modelLog2 = new TBookingLog();
            $modelLog2->id_booking = $id_booking;
            $modelLog2->id_event   = self::EVENT_READ_CHECK;
            $modelLog2->id_user    = Yii::$app->user->identity->id;
            $modelLog2->datetime   = date('Y-m-d H:i:s');
            $modelLog2->save(false);
        }
        $modelLog->save(false);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdBooking()
    {
        return $this->hasOne(\common\models\TBooking::className(), ['id' => 'id_booking']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEvent()
    {
        return $this->hasOne(TBookingLogEvent::className(), ['id' => 'id_event']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }
}
