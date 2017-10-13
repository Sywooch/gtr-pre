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
}
