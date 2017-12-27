<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_private_cart".
 *
 * @property string $session_key
 * @property integer $id_trip
 * @property integer $type
 * @property integer $adult
 * @property integer $child
 * @property integer $infant
 * @property string $currency
 * @property integer $exchange
 * @property string $start_time
 * @property string $expired_time
 *
 * @property TKurs $currency0
 * @property TPrivateTrip $idTrip
 */
class TPrivateCart extends \yii\db\ActiveRecord
{
    const LEGHT_SESSION_KEY = 5;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_private_cart';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['session_key', 'id_trip', 'type', 'adult', 'currency', 'exchange', 'start_time', 'expired_time','trip_date'], 'required'],
            [['id_trip', 'type', 'adult', 'child', 'infant', 'exchange'], 'integer'],
            [['start_time', 'expired_time','trip_date'], 'safe'],
            [['session_key', 'currency'], 'string', 'max' => 5],
            [['currency'], 'exist', 'skipOnError' => true, 'targetClass' => TKurs::className(), 'targetAttribute' => ['currency' => 'currency']],
            [['id_trip'], 'exist', 'skipOnError' => true, 'targetClass' => TPrivateTrip::className(), 'targetAttribute' => ['id_trip' => 'id']],
        ];
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'session_key' => Yii::t('app', 'Session Key'),
            'id_trip' => Yii::t('app', 'Id Trip'),
            'type' => Yii::t('app', '1 return 0 one way'),
            'adult' => Yii::t('app', 'Adult'),
            'child' => Yii::t('app', 'Child'),
            'infant' => Yii::t('app', 'Infant'),
            'currency' => Yii::t('app', 'Currency'),
            'exchange' => Yii::t('app', 'Exchange'),
            'start_time' => Yii::t('app', 'Start Time'),
            'expired_time' => Yii::t('app', 'Expired Time'),
        ];
    }

    public function generateSessionKey($attribute, $length = 5){
        // $pool = array_merge(range(0,9),range('A', 'Z')); 
        // for($i=0; $i < $length; $i++) {
        //     $key[] = $pool[mt_rand(0, count($pool) - 1)];
        // }
            $session_key = Yii::$app->getSecurity()->generateRandomString($length);
         
        if(!self::findOne([$attribute => $session_key])) {
            return $session_key;
        }else{
            return $this->generateSessionKey($attribute,$length);
        }
            
    }

    public static function addPrivateCart(array $detail){
        $session = Yii::$app->session;
        $now = date('Y-m-d H:i:s');
        $session['timeout'] = date('Y-m-d H:i:s',strtotime('+ 30 MINUTES',strtotime($now)));
        if (!isset($session['session_key'])) {
            $session['session_key']= self::generateSessionKey('session_key');
        }
        $currency = TKurs::find()->where(['currency'=>$session['currency']])->asArray()->one();
        if (($modelCart = TPrivateCart::find()->where(['session_key'=>$session['session_key'],'id_trip'=>$detail['id_trip'],'trip_date'=>$detail['trip_date']])->one()) === null) {
                $modelCart               = new TPrivateCart();
                $modelCart->session_key  = $session['session_key'];
                $modelCart->id_trip      = $detail['id_trip'];
                $modelCart->trip_date    = $detail['trip_date'];
                $modelCart->type         = $detail['type'];
                $modelCart->adult        = $detail['adults'];
                $modelCart->child        = $detail['childs'];
                $modelCart->infant       = $detail['infants'];
                $modelCart->currency     = $currency['currency'];
                $modelCart->exchange     = $currency['kurs'];
                $modelCart->start_time   = date('Y-m-d H:i:s');
                $modelCart->expired_time = date('Y-m-d H:i:s', strtotime('+30 minutes'));
                $modelCart->validate();
                $modelCart->save(false);
        }else{
               // $modelCart->type = $detail['type'];
                $modelCart->session_key  = $session['session_key'];
                $modelCart->adult        = $modelCart->adult+$detail['adults'];
                $modelCart->child        = $modelCart->child+$detail['childs'];
                $modelCart->infant       = $modelCart->infant+$detail['infants'];
                $modelCart->currency     = $currency['currency'];
                $modelCart->exchange     = $currency['kurs'];
                $modelCart->start_time   = date('Y-m-d H:i:s');
                $modelCart->expired_time = date('Y-m-d H:i:s', strtotime('+30 minutes'));
                $modelCart->validate();
                $modelCart->save(false);
        }
        return true;

        
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
    public function getIdTrip()
    {
        return $this->hasOne(TPrivateTrip::className(), ['id' => 'id_trip']);
    }
}
