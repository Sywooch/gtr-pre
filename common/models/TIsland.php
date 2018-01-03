<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_island".
 *
 * @property integer $id
 * @property string $island
 *
 * @property THarbor[] $tHarbors
 * @property TShuttleArea[] $tShuttleAreas
 */
class TIsland extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_island';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['island'], 'required'],
            [['island'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'island' => Yii::t('app', 'Island'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTHarbors()
    {
        return $this->hasMany(THarbor::className(), ['id_island' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTShuttleAreas()
    {
        return $this->hasMany(TShuttleArea::className(), ['id_island' => 'id']);
    }
}
