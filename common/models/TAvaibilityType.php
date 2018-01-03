<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_avaibility_type".
 *
 * @property integer $id
 * @property string $type
 *
 * @property TAvaibility[] $tAvaibilities
 * @property TTrip[] $tTrips
 */
class TAvaibilityType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_avaibility_type';
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
    public function getTAvaibilities()
    {
        return $this->hasMany(TAvaibility::className(), ['type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTTrips()
    {
        return $this->hasMany(TTrip::className(), ['id_type_avaibility' => 'id']);
    }
}
