<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_bank_transfer_status_code".
 *
 * @property integer $status_code
 *
 * @property TBankTransferTransaction[] $tBankTransferTransactions
 */
class TBankTransferStatusCode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_bank_transfer_status_code';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status_code'], 'required'],
            [['status_code'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'status_code' => 'Status Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTBankTransferTransactions()
    {
        return $this->hasMany(TBankTransferTransaction::className(), ['status_code' => 'status_code']);
    }
}
