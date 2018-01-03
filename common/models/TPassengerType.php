<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_passenger_type".
 *
 * @property integer $id
 * @property string $type
 *
 * @property TPassenger[] $tPassengers
 */
class TPassengerType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_passenger_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type'], 'string', 'max' => 10],
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
    public function getTPassengers()
    {
        return $this->hasMany(TPassenger::className(), ['id_type' => 'id']);
    }
}
