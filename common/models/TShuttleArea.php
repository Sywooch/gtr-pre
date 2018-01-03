<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_shuttle_area".
 *
 * @property integer $id
 * @property integer $id_island
 * @property string $area
 *
 * @property TIsland $idIsland
 * @property TShuttleLocation[] $tShuttleLocations
 */
class TShuttleArea extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_shuttle_area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_island', 'area'], 'required'],
            [['id_island'], 'integer'],
            [['area'], 'string', 'max' => 50],
            [['id_island'], 'exist', 'skipOnError' => true, 'targetClass' => TIsland::className(), 'targetAttribute' => ['id_island' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_island' => Yii::t('app', 'Island'),
            'area' => Yii::t('app', 'Area'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdIsland()
    {
        return $this->hasOne(TIsland::className(), ['id' => 'id_island']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTShuttleLocations()
    {
        return $this->hasMany(TShuttleLocation::className(), ['id_area' => 'id']);
    }
}
