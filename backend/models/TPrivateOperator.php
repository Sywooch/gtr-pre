<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "t_private_operator".
 *
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property string $datetime
 *
 * @property TPrivateBooking[] $tPrivateBookings
 */
class TPrivateOperator extends \yii\db\ActiveRecord
{

    const STATUS_ON    = 1;
    const STATUS_OFF   = 2;
    const STATUS_BLOCK = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_private_operator';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'phone','email'], 'required'],
            [['email'],'email'],
            [['datetime'], 'safe'],
            [['datetime'],'default','value'=>date('Y-m-d H:i:00')],
            [['id_status'],'default','value'=>self::STATUS_ON],
            [['name','email'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 25],
            [['id_status'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\TStatusTrip::className(), 'targetAttribute' => ['id_status' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'       => 'ID',
            'name'     => 'Name',
            'phone'    => 'Phone',
            'email'    => 'Email',
            'datetime' => 'Datetime',
        ];
    }

    public static function addPrivateOperator(array $data){
        $modelOperator = new TPrivateOperator();
        $modelOperator->name = $data['name'];
        $modelOperator->phone = $data ['phone'];
        $modelOperator->email = $data['email'];
        $modelOperator->validate();
        $modelOperator->save(false);
    }
    
    public static function geAvailableOperator($asArray = false){
        if ($asArray == true) {
            return $modelOperator = TPrivateOperator::find()->where(['id_status'=>self::STATUS_ON])->asArray()->all();
        }else{
            return $modelOperator = TPrivateOperator::find()->where(['id_status'=>self::STATUS_ON])->all();
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTPrivateBookings()
    {
        return $this->hasMany(TPrivateBooking::className(), ['id_operator' => 'id']);
    }
     public function getIdStatus()
    {
        return $this->hasOne(\common\models\TStatusTrip::className(), ['id' => 'id_status']);
    }
}
