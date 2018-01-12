<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_status_trip".
 *
 * @property integer $id
 * @property string $status
 *
 * @property TTrip[] $tTrips
 */
class TStatusTrip extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_status_trip';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'required'],
            [['id'], 'integer'],
            [['status'], 'string', 'max' => 10],
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
    public function getTTrips()
    {
        return $this->hasMany(TTrip::className(), ['status' => 'id']);
    }
}
