<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_payment".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property integer $id_payment_method
 * @property string $currency
 * @property integer $exchange
 * @property double $send_amount
 * @property string $token
 * @property string $exp
 * @property integer $status
 * @property integer $update_at
 *
 * @property TKurs $currency0
 * @property TPaymentMethod $idPaymentMethod
 */
class TPaymentDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'phone','token','exp','total_payment','total_payment_idr','name'], 'required'],
            [['exchange', 'status', 'update_at','total_payment_idr'], 'integer'],
            [['email'],'email'],
            [['exp', 'update_at'], 'safe'],
            [['total_payment'], 'number'],
            [['name', 'email'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 20],
            [['currency'], 'string', 'max' => 5],
            [['token'], 'string', 'max' => 25],
            [['token'], 'unique'],
            [['currency'], 'exist', 'skipOnError' => true, 'targetClass' => TKurs::className(), 'targetAttribute' => ['currency' => 'currency']],
        ];
    }

     public function generatePaymentToken($attribute, $length = 25){
       //$token = Yii::$app->getSecurity()->generateRandomString($length);
        $pool = array_merge(range(0,9),range('A', 'Z')); 
    for($i=0; $i < $length; $i++) {
        $key[] = $pool[mt_rand(0, count($pool) - 1)];
    }
        $token = join($key);

        if(!$this->findOne([$attribute => $token])) {
            return $token;
        }else{
            return $this->generatePaymentToken($attribute,$length);
        }
            
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'id_payment_method' => Yii::t('app', 'Id Payment Method'),
            'currency' => Yii::t('app', 'Currency'),
            'exchange' => Yii::t('app', 'Exchange'),
            'send_amount' => Yii::t('app', 'Send Amount'),
            'token' => Yii::t('app', 'Token'),
            'exp' => Yii::t('app', 'Exp Time'),
            'status' => Yii::t('app', 'Status'),
            'update_at' => Yii::t('app', 'Update At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency0()
    {
        return $this->hasOne(TKurs::className(), ['currency' => 'currency']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPaymentMethod()
    {
        return $this->hasOne(TPaymentMethod::className(), ['id' => 'id_payment_method']);
    }
}
