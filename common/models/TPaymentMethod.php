<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_payment_method".
 *
 * @property integer $id
 * @property string $method
 *
 * @property TBooking[] $tBookings
 */
class TPaymentMethod extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_payment_method';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['method'], 'required'],
            [['method'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'method' => Yii::t('app', 'Method'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTBookings()
    {
        return $this->hasMany(TBooking::className(), ['id_payment_method' => 'id']);
    }
}
