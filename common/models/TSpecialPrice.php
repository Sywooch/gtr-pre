<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_special_price".
 *
 * @property integer $id
 * @property integer $id_trip
 * @property string $event
 * @property integer $adult_price
 * @property integer $child_price
 * @property integer $infant_price
 * @property integer $author
 *
 * @property TTrip $idTrip
 */
class TSpecialPrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_special_price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_trip', 'event', 'adult_price', 'child_price', 'infant_price', 'author'], 'required'],
            [['id_trip', 'adult_price', 'child_price', 'infant_price', 'author'], 'integer'],
            [['event'], 'string', 'max' => 50],
            [['id_trip'], 'exist', 'skipOnError' => true, 'targetClass' => TTrip::className(), 'targetAttribute' => ['id_trip' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_trip' => Yii::t('app', 'Id Trip'),
            'event' => Yii::t('app', 'Event'),
            'adult_price' => Yii::t('app', 'Adult Price'),
            'child_price' => Yii::t('app', 'Child Price'),
            'infant_price' => Yii::t('app', 'Infant Price'),
            'author' => Yii::t('app', 'Author'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTrip()
    {
        return $this->hasOne(TTrip::className(), ['id' => 'id_trip']);
    }
}
