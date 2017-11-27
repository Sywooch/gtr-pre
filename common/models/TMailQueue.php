<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_mail_queue".
 *
 * @property integer $id
 * @property integer $id_payment
 * @property integer $id_type
 * @property integer $status
 * @property integer $processor
 * @property string $datetime
 *
 * @property TPayment $idPayment
 * @property User $processor0
 * @property TTypeQueue $idType
 */
class TMailQueue extends \yii\db\ActiveRecord
{
    const STATUS_QUEUE   = "1"; // SAME FOR ETicket
    const STATUS_PROCESS = "2"; // SAME FOR INVOICe
    const STATUS_SUCCESS = "3";
    const STATUS_RETRY   = "4";
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_mail_queue';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_payment', 'id_type', 'status'], 'required'],
            [['id_payment', 'id_type', 'status', 'processor'], 'integer'],
            [['datetime'], 'safe'],
            [['id_type'],'in','range'=>[self::STATUS_QUEUE,self::STATUS_PROCESS]],
            [['status'],'in','range'=>[self::STATUS_QUEUE,self::STATUS_PROCESS,self::STATUS_SUCCESS,self::STATUS_RETRY]],
            [['id_payment'], 'exist', 'skipOnError' => true, 'targetClass' => TPayment::className(), 'targetAttribute' => ['id_payment' => 'id']],
            [['processor'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['processor' => 'id']],
            [['id_type'], 'exist', 'skipOnError' => true, 'targetClass' => TTypeQueue::className(), 'targetAttribute' => ['id_type' => 'id']],
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
            'id_type' => Yii::t('app', 'Id Type'),
            'status' => Yii::t('app', 'Status'),
            'processor' => Yii::t('app', 'Processor'),
            'datetime' => Yii::t('app', 'Datetime'),
        ];
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
    public function getProcessor0()
    {
        return $this->hasOne(User::className(), ['id' => 'processor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdType()
    {
        return $this->hasOne(TTypeQueue::className(), ['id' => 'id_type']);
    }

    public static function addTicketQueue($id_payment){
        $modelQueue = new TMailQueue();
        $modelQueue->id_payment = $id_payment;
        $modelQueue->status = self::STATUS_QUEUE;
        $modelQueue->id_type = self::STATUS_QUEUE; // Type E Ticket
        $modelQueue->save(false);
    }

    public static function addInvoiceQueue($id_payment){
        $modelQueue = new TMailQueue();
        $modelQueue->id_payment = $id_payment;
        $modelQueue->status = self::STATUS_QUEUE;
        $modelQueue->id_type = self::STATUS_PROCESS; // TYpe Invoice
        $modelQueue->save(false);
    }

    public static function getQueueList($type){
        if(($Queue = TMailQueue::find()->where(['status'=>self::STATUS_RETRY])->andWhere(['id_type'=>$type])->orderBy(['datetime'=>SORT_ASC])->one())!== null){
            return $Queue;
        }else{
            return TMailQueue::find()->where(['status'=>self::STATUS_QUEUE])->andWhere(['id_type'=>$type])->orderBy(['datetime'=>SORT_ASC])->one();
        }
    }

    public static function setQueueStatus($status){
        $this->status = $status;
        $this->save(false);
    }


}
