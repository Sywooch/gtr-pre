<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_kurs".
 *
 * @property string $currency
 * @property integer $kurs
 * @property string $update_at
 *
 * @property TBooking[] $tBookings
 */
class TKurs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_kurs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['currency', 'kurs','name'], 'required'],
            [['kurs'], 'integer'],
            [['name'],'string','max'=>50],
            [['update_at'], 'safe'],
            [['currency'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'currency' => Yii::t('app', 'Currency'),
            'name' => Yii::t('app', 'Currency Name'),
            'kurs' => Yii::t('app', 'Kurs'),
            'update_at' => Yii::t('app', 'Update At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTBookings()
    {
        return $this->hasMany(TBooking::className(), ['currency' => 'currency']);
    }
}
