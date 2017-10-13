<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_harbor".
 *
 * @property integer $id
 * @property string $name
 * @property integer $id_island
 *
 * @property TIsland $idIsland
 * @property TRoute[] $tRoutes
 * @property TRoute[] $tRoutes0
 */
class THarbor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_harbor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'id_island'], 'required'],
            [['id_island'], 'integer'],
            [['name'], 'string', 'max' => 50],
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
            'name' => Yii::t('app', 'Harbor Name'),
            'id_island' => Yii::t('app', 'Island'),
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
    public function getTRoutes()
    {
        return $this->hasMany(TRoute::className(), ['departure' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTRoutes0()
    {
        return $this->hasMany(TRoute::className(), ['arrival' => 'id']);
    }
}
