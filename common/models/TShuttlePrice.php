<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_shuttle_price".
 *
 * @property integer $id
 * @property integer $id_company
 * @property integer $id_lokasi
 * @property integer $id_shuttle_type
 * @property integer $price_sharing
 * @property integer $price_car
 * @property integer $price_elf
 * @property string $pickup_time
 * @property string $datetime
 *
 * @property TPickup[] $tPickups
 * @property TCompany $idCompany
 * @property TShuttleLocation $idLokasi
 * @property TShuttleType $idShuttleType
 */
class TShuttlePrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_shuttle_price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_company', 'id_lokasi', 'id_shuttle_type', 'price_sharing', 'price_car', 'price_elf'], 'required'],
            [['id_company', 'id_lokasi', 'id_shuttle_type', 'price_sharing', 'price_car', 'price_elf'], 'integer'],
            [['datetime'], 'safe'],
            [['pickup_time'], 'string', 'max' => 25],
            [['id_company'], 'exist', 'skipOnError' => true, 'targetClass' => TCompany::className(), 'targetAttribute' => ['id_company' => 'id']],
            [['id_lokasi'], 'exist', 'skipOnError' => true, 'targetClass' => TShuttleLocation::className(), 'targetAttribute' => ['id_lokasi' => 'id']],
            [['id_shuttle_type'], 'exist', 'skipOnError' => true, 'targetClass' => TShuttleType::className(), 'targetAttribute' => ['id_shuttle_type' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_company' => Yii::t('app', 'Id Company'),
            'id_lokasi' => Yii::t('app', 'Id Lokasi'),
            'id_shuttle_type' => Yii::t('app', 'Id Shuttle Type'),
            'price_sharing' => Yii::t('app', 'Price Sharing'),
            'price_car' => Yii::t('app', 'Price Car'),
            'price_elf' => Yii::t('app', 'Price Elf'),
            'pickup_time' => Yii::t('app', 'Pickup Time'),
            'datetime' => Yii::t('app', 'Datetime'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTShuttles()
    {
        return $this->hasMany(TShuttle::className(), ['id_time' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCompany()
    {
        return $this->hasOne(TCompany::className(), ['id' => 'id_company']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdLokasi()
    {
        return $this->hasOne(TShuttleLocation::className(), ['id' => 'id_lokasi']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdShuttleType()
    {
        return $this->hasOne(TShuttleType::className(), ['id' => 'id_shuttle_type']);
    }
}
