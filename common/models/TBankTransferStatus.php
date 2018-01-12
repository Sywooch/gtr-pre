<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_bank_transfer_status".
 *
 * @property integer $id
 * @property string $status
 *
 * @property TBankTransferTransaction[] $tBankTransferTransactions
 */
class TBankTransferStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_bank_transfer_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'required'],
            [['id'], 'integer'],
            [['status'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTBankTransferTransactions()
    {
        return $this->hasMany(TBankTransferTransaction::className(), ['id_status' => 'id']);
    }

    public static function getStatus($status){
        if (($modelStatus = TBankTransferStatus::find()->where(['status'=>$status])->asArray()->one()) !== null) {
            return $modelStatus['id'];
        }else{
            return null;
        }
    }
}
