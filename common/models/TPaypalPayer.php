<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_paypal_payer".
 *
 * @property string $id
 * @property string $full_name
 * @property string $email
 * @property string $address
 * @property string $id_country
 * @property integer $id_status
 *
 * @property TCountry $idCountry
 * @property TPaypalPayerStatus $idStatus
 * @property TPaypalTransaction[] $tPaypalTransactions
 */
class TPaypalPayer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_paypal_payer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'full_name', 'email', 'address', 'id_country', 'id_status'], 'required'],
            [['address'], 'string'],
            [['id_status'], 'integer'],
            [['id'], 'string', 'max' => 15],
            [['full_name'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 50],
            [['id_country'], 'string', 'max' => 2],
            [['id_country'], 'exist', 'skipOnError' => true, 'targetClass' => TCountry::className(), 'targetAttribute' => ['id_country' => 'id']],
            [['id_status'], 'exist', 'skipOnError' => true, 'targetClass' => TPaypalPayerStatus::className(), 'targetAttribute' => ['id_status' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'full_name' => Yii::t('app', 'Full Name'),
            'email' => Yii::t('app', 'Email'),
            'address' => Yii::t('app', 'Address'),
            'id_country' => Yii::t('app', 'Id Country'),
            'id_status' => Yii::t('app', 'Id Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCountry()
    {
        return $this->hasOne(TCountry::className(), ['id' => 'id_country']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdStatus()
    {
        return $this->hasOne(TPaypalPayerStatus::className(), ['id' => 'id_status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTPaypalTransactions()
    {
        return $this->hasMany(TPaypalTransaction::className(), ['id_payer' => 'id']);
    }

    public function checkPayer(array $arrayPayer){
        if (($modelPayer = TPaypalPayer::findOne($arrayPayer['payer_info']['payer_id'])) !== null ) {
            return $modelPayer->id;
        }else{
            try {
                $modelPayer             = new TPaypalPayer();
                $modelPayer->id         = $arrayPayer['payer_info']['payer_id'];
                $modelPayer->full_name  = $arrayPayer['payer_info']['first_name']." ".$arrayPayer['payer_info']['last_name'];
                $modelPayer->email      = $arrayPayer['payer_info']['email'];
                $modelPayer->address    = "Street : ".$arrayPayer['payer_info']['shipping_address']['line1']." | City: ".$arrayPayer['payer_info']['shipping_address']['city']." | State : ".$arrayPayer['payer_info']['shipping_address']['state']." | Post Code : ".$arrayPayer['payer_info']['shipping_address']['postal_code'];
                $modelPayer->id_country = $arrayPayer['payer_info']['country_code'];
                if (($modelPayerStatus = TPaypalPayerStatus::find()->where(['status'=>$arrayPayer['status']])->asArray()->one()) !== null) {
                    $modelPayer->id_status = $modelPayerStatus['id'];
                }else{
                    $newPayerStatus = new TPaypalPayerStatus();
                    $newPayerStatus->status = $arrayPayer['status'];
                    $newPayerStatus->save();
                    $modelPayer->id_status = $newPayerStatus->id;
                }
                $modelPayer->validate();
                $modelPayer->save(false);
                return $modelPayer->id;
            } catch (Exception $e) {
                return "failed-insert";
            }
               
        }
    }
}
