<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_payment_type".
 *
 * @property integer $id
 * @property string $type
 *
 * @property TPayment[] $tPayments
 */
class TPaymentType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_payment_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTPayments()
    {
        return $this->hasMany(TPayment::className(), ['id_payment_type' => 'id']);
    }
}
