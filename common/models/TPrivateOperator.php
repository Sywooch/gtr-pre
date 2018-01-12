<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_private_operator".
 *
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property string $datetime
 *
 * @property TPrivateBooking[] $tPrivateBookings
 */
class TPrivateOperator extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_private_operator';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'datetime'], 'required'],
            [['datetime'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'phone' => Yii::t('app', 'Phone'),
            'datetime' => Yii::t('app', 'Datetime'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTPrivateBookings()
    {
        return $this->hasMany(TPrivateBooking::className(), ['id_operator' => 'id']);
    }
}
