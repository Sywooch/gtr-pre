<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_shuttle_type".
 *
 * @property integer $id
 * @property string $type
 *
 * @property TDrop[] $tDrops
 * @property TPickup[] $tPickups
 * @property TShuttlePrice[] $tShuttlePrices
 */
class TShuttleType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_shuttle_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type'], 'string', 'max' => 25],
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
    public function getTShuttles()
    {
        return $this->hasMany(TShuttle::className(), ['id_pickup_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTShuttlePrices()
    {
        return $this->hasMany(TShuttlePrice::className(), ['id_shuttle_type' => 'id']);
    }
}
