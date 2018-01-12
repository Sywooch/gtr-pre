<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_private_passenger".
 *
 * @property integer $id
 * @property string $id_booking
 * @property string $name
 * @property integer $id_nationality
 * @property string $birthday
 * @property integer $id_type
 *
 * @property TPrivateBooking $idBooking
 * @property TNationality $idNationality
 * @property TPassengerType $idType
 */
class TPrivatePassenger extends \yii\db\ActiveRecord
{
    const TYPE_ADULT  = 1;
    const TYPE_CHILD  = 2;
    const TYPE_INFANT = 3;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_private_passenger';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_booking', 'name', 'id_nationality', 'id_type'], 'required'],
            [['id_nationality', 'id_type'], 'integer'],
            [['birthday'], 'safe'],
            [['id_booking'], 'string', 'max' => 5],
            [['name'], 'string', 'max' => 50],
            [['id_type'],'in','range'=>[self::TYPE_ADULT,self::TYPE_CHILD,self::TYPE_INFANT]],
            [['id_booking'], 'exist', 'skipOnError' => true, 'targetClass' => TPrivateBooking::className(), 'targetAttribute' => ['id_booking' => 'id']],
            [['id_nationality'], 'exist', 'skipOnError' => true, 'targetClass' => TNationality::className(), 'targetAttribute' => ['id_nationality' => 'id']],
            [['id_type'], 'exist', 'skipOnError' => true, 'targetClass' => TPassengerType::className(), 'targetAttribute' => ['id_type' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_booking' => Yii::t('app', 'Id Booking'),
            'name' => Yii::t('app', 'Name'),
            'id_nationality' => Yii::t('app', 'Id Nationality'),
            'birthday' => Yii::t('app', 'Birthday'),
            'id_type' => Yii::t('app', 'Id Type'),
        ];
    }

    public static function addPrivatePassengers(array $data){
        $saveChild                 = new TPrivatePassenger();
        $saveChild->id_booking     = $data['id_booking'];
        $saveChild->name           = $data['name'];
        $saveChild->id_nationality = $data['id_nationality'];
        $saveChild->birthday       = $data['birthday'];
        $saveChild->id_type        = $data['type'];
        $saveChild->validate();
        $saveChild->save(false); 
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdBooking()
    {
        return $this->hasOne(TPrivateBooking::className(), ['id' => 'id_booking']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdNationality()
    {
        return $this->hasOne(TNationality::className(), ['id' => 'id_nationality']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdType()
    {
        return $this->hasOne(TPassengerType::className(), ['id' => 'id_type']);
    }
}
