<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_private_route".
 *
 * @property integer $id
 * @property integer $from_route
 * @property integer $to_route
 *
 * @property TPrivateLocation $fromRoute
 * @property TPrivateLocation $toRoute
 * @property TPrivateTrip[] $tPrivateTrips
 */
class TPrivateRoute extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_private_route';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_route', 'to_route'], 'required'],
            [['from_route', 'to_route'], 'integer'],
            [['from_route'], 'exist', 'skipOnError' => true, 'targetClass' => TPrivateLocation::className(), 'targetAttribute' => ['from_route' => 'id']],
            [['to_route'], 'exist', 'skipOnError' => true, 'targetClass' => TPrivateLocation::className(), 'targetAttribute' => ['to_route' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'from_route' => Yii::t('app', 'From Route'),
            'to_route' => Yii::t('app', 'To Route'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFromRoute()
    {
        return $this->hasOne(TPrivateLocation::className(), ['id' => 'from_route']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToRoute()
    {
        return $this->hasOne(TPrivateLocation::className(), ['id' => 'to_route']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTPrivateTrips()
    {
        return $this->hasMany(TPrivateTrip::className(), ['id_route' => 'id']);
    }
}
