<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_shuttle_location".
 *
 * @property integer $id
 * @property integer $id_area
 * @property string $location_name
 * @property string $address
 * @property string $phone
 * @property integer $datetime
 * @property integer $author
 *
 * @property TDrop[] $tDrops
 * @property TPickup[] $tPickups
 * @property TShuttleArea $idArea
 * @property TShuttlePrice[] $tShuttlePrices
 */
class TShuttleLocation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_shuttle_location';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_area', 'location_name', 'address'], 'required'],
            [['id_area', 'datetime', 'author'], 'integer'],
            [['location_name', 'address'], 'string'],
            [['phone'], 'string', 'max' => 15],
            [['id_area'], 'exist', 'skipOnError' => true, 'targetClass' => TShuttleArea::className(), 'targetAttribute' => ['id_area' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_area' => Yii::t('app', 'Area'),
            'location_name' => Yii::t('app', 'Location Name'),
            'address' => Yii::t('app', 'Address'),
            'phone' => Yii::t('app', 'Phone'),
            'datetime' => Yii::t('app', 'Datetime'),
            'author' => Yii::t('app', 'Author'),
        ];
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTShuttles()
    {
        return $this->hasMany(TShuttle::className(), ['id_location' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdArea()
    {
        return $this->hasOne(TShuttleArea::className(), ['id' => 'id_area']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTShuttlePrices()
    {
        return $this->hasMany(TShuttlePrice::className(), ['id_lokasi' => 'id']);
    }
}
