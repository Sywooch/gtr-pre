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
}
