<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_avaibility".
 *
 * @property integer $id
 * @property integer $id_trip
 * @property integer $type
 * @property integer $stok
 * @property integer $sold
 * @property integer $process
 * @property integer $cancel
 * @property integer $datetime
 *
 * @property TTrip $idTrip
 * @property TAvaibilityType $type0
 */
class TAvaibility extends \yii\db\ActiveRecord
{
    const TYPE_NORMAL = 1;
    const TYPE_KHUSUS = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_avaibility';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_trip', 'stok'], 'required'],
            ['type', 'default', 'value' => self::TYPE_NORMAL],
            ['type', 'in', 'range' => [self::TYPE_NORMAL, self::TYPE_KHUSUS]],
            [['id_trip', 'type', 'stok', 'sold', 'process', 'cancel', 'datetime'], 'integer'],
            [['id_trip'], 'exist', 'skipOnError' => true, 'targetClass' => TTrip::className(), 'targetAttribute' => ['id_trip' => 'id']],
            [['type'], 'exist', 'skipOnError' => true, 'targetClass' => TAvaibilityType::className(), 'targetAttribute' => ['type' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_trip' => Yii::t('app', 'Trip'),
            'type' => Yii::t('app', 'Type'),
            'stok' => Yii::t('app', 'Avaible Seat'),
            'sold' => Yii::t('app', 'Sold Seat'),
            'process' => Yii::t('app', 'On Process Seat'),
            'cancel' => Yii::t('app', 'Canceled Seat'),
            'datetime' => Yii::t('app', 'Datetime'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTrip()
    {
        return $this->hasOne(TTrip::className(), ['id' => 'id_trip']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType0()
    {
        return $this->hasOne(TAvaibilityType::className(), ['id' => 'type']);
    }
}
