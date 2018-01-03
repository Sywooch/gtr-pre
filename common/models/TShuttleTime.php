<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_shuttle_time".
 *
 * @property integer $id
 * @property integer $id_company
 * @property integer $id_route
 * @property string $dept_time
 * @property integer $id_area
 * @property string $shuttle_time_start
 * @property string $shuttle_time_end
 * @property integer $created_at
 *
 * @property TShuttleArea $idArea
 * @property TCompany $idCompany
 * @property TRoute $idRoute
 */
class TShuttleTime extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_shuttle_time';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_company', 'id_route', 'dept_time', 'id_area', 'shuttle_time_start', 'shuttle_time_end'], 'required'],
            [['id_company', 'id_route', 'id_area', 'created_at'], 'integer'],
            [['dept_time', 'shuttle_time_start', 'shuttle_time_end'], 'safe'],
            [['id_area'], 'exist', 'skipOnError' => true, 'targetClass' => TShuttleArea::className(), 'targetAttribute' => ['id_area' => 'id']],
            [['id_company'], 'exist', 'skipOnError' => true, 'targetClass' => TCompany::className(), 'targetAttribute' => ['id_company' => 'id']],
            [['id_route'], 'exist', 'skipOnError' => true, 'targetClass' => TRoute::className(), 'targetAttribute' => ['id_route' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_company' => Yii::t('app', 'Company'),
            'id_route' => Yii::t('app', 'Route'),
            'dept_time' => Yii::t('app', 'Dept Time'),
            'id_area' => Yii::t('app', 'Area'),
            'shuttle_time_start' => Yii::t('app', 'Shuttle Time Start'),
            'shuttle_time_end' => Yii::t('app', 'Shuttle Time End'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
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
    public function getIdCompany()
    {
        return $this->hasOne(TCompany::className(), ['id' => 'id_company']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdRoute()
    {
        return $this->hasOne(TRoute::className(), ['id' => 'id_route']);
    }
}
