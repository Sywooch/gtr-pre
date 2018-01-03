<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_private_location".
 *
 * @property integer $id
 * @property string $location
 *
 * @property TPrivateRoute[] $tPrivateRoutes
 * @property TPrivateRoute[] $tPrivateRoutes0
 */
class TPrivateLocation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_private_location';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['location'], 'required'],
            [['location'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'location' => Yii::t('app', 'Location'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTPrivateRoutes()
    {
        return $this->hasMany(TPrivateRoute::className(), ['from_route' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTPrivateRoutes0()
    {
        return $this->hasMany(TPrivateRoute::className(), ['to_route' => 'id']);
    }

    public static function getAllLocation(){
        return TPrivateLocation::find()->asArray()->all();
    }
}
