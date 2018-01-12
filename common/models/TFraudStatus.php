<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_fraud_status".
 *
 * @property integer $id
 * @property string $fraud_status
 *
 * @property TBankTransferTransaction[] $tBankTransferTransactions
 */
class TFraudStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_fraud_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fraud_status'], 'required'],
            [['fraud_status'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fraud_status' => 'Fraud Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTBankTransferTransactions()
    {
        return $this->hasMany(TBankTransferTransaction::className(), ['id_fraud_status' => 'id']);
    }

    public static function getFraudStatus($status){
        if (($modelFraudSatatus = TFraudStatus::find()->where(['fraud_status'=>$status])->asArray()->one()) !== null) {
            return $modelFraudSatatus['id'];
        }else{
            return null;
        }
    }
}
