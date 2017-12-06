<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "t_payment_log".
 *
 * @property integer $id
 * @property integer $id_payment
 * @property integer $id_event
 * @property integer $id_user
 * @property string $note
 * @property string $datetime
 *
 * @property TBookingLogEvent $idEvent
 * @property TPayment $idPayment
 * @property User $idUser
 */
class TPaymentLog extends \yii\db\ActiveRecord
{
    const EVENT_CONFIRM    = 1;
    const EVENT_REJECT     = 2;
    const EVENT_READ_CHECK = 3;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_payment_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_payment', 'id_event', 'datetime'], 'required'],
            [['id_payment', 'id_event', 'id_user'], 'integer'],
            [['datetime'], 'safe'],
            [['id_event'],'in','range'=>[self::EVENT_CONFIRM,self::EVENT_REJECT,self::EVENT_READ_CHECK]],
            [['note'], 'string', 'max' => 100],
            [['id_event'], 'exist', 'skipOnError' => true, 'targetClass' => TBookingLogEvent::className(), 'targetAttribute' => ['id_event' => 'id']],
            [['id_payment'], 'exist', 'skipOnError' => true, 'targetClass' => TPayment::className(), 'targetAttribute' => ['id_payment' => 'id']],
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
            'id_payment' => Yii::t('app', 'Id Payment'),
            'id_event' => Yii::t('app', 'Id Event'),
            'id_user' => Yii::t('app', 'Id User'),
            'note' => Yii::t('app', 'Note'),
            'datetime' => Yii::t('app', 'Datetime'),
        ];
    }

    public static function addPaymmentLog($id_payment,$id_event){
        $modelPaymentLog = new TPaymentLog();
        $modelPaymentLog->id_payment = $id_payment;
        $modelPaymentLog->id_event   = $id_event;
        $modelPaymentLog->id_user    = Yii::$app->user->identity->id;
        $modelPaymentLog->datetime   = date('Y-m-d H:i:s');
        if ($modelPaymentLog->id_event == self::EVENT_CONFIRM) {
            $modelPaymentLog2 = new TPaymentLog();
            $modelPaymentLog2->id_payment = $id_payment;
            $modelPaymentLog2->id_event   = self::EVENT_READ_CHECK;
            $modelPaymentLog2->id_user    = Yii::$app->user->identity->id;
            $modelPaymentLog2->datetime   = date('Y-m-d H:i:s');
            $modelPaymentLog2->save(false);
        }
        $modelPaymentLog->save(false);
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
    public function getIdPayment()
    {
        return $this->hasOne(TPayment::className(), ['id' => 'id_payment']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }
}
