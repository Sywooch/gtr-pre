<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_paypal_payer_status".
 *
 * @property integer $id
 * @property string $status
 *
 * @property TPaypalPayer[] $tPaypalPayers
 */
class TPaypalPayerStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_paypal_payer_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'required'],
            [['id'], 'integer'],
            [['status'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTPaypalPayers()
    {
        return $this->hasMany(TPaypalPayer::className(), ['id_status' => 'id']);
    }
}
