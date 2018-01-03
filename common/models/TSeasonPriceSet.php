<?php

namespace common\models;

use Yii;
 use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "t_season_price_set".
 *
 * @property integer $id
 * @property integer $id_company
 * @property integer $id_season_type
 * @property integer $id_route
 * @property integer $adult_price
 * @property integer $child_price
 * @property integer $infant_price
 * @property string $start_date
 * @property string $end_date
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property TCompany $idCompany
 * @property TSeasonType $idSeasonType
 * @property TRoute $idRoute
 */
class TSeasonPriceSet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_season_price_set';
    }



    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_company', 'id_season_type', 'id_route', 'adult_price', 'child_price', 'infant_price', 'start_date', 'end_date'], 'required'],
            [['id_company', 'id_season_type', 'id_route', 'adult_price', 'child_price', 'infant_price'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['id_company'], 'exist', 'skipOnError' => true, 'targetClass' => TCompany::className(), 'targetAttribute' => ['id_company' => 'id']],
            [['id_season_type'], 'exist', 'skipOnError' => true, 'targetClass' => TSeasonType::className(), 'targetAttribute' => ['id_season_type' => 'id']],
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
            'id_season_type' => Yii::t('app', 'Season Type'),
            'id_route' => Yii::t('app', 'Route'),
            'adult_price' => Yii::t('app', 'Adult Price'),
            'child_price' => Yii::t('app', 'Child Price'),
            'infant_price' => Yii::t('app', 'Infant Price'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
            
        ];
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
    public function getIdSeasonType()
    {
        return $this->hasOne(TSeasonType::className(), ['id' => 'id_season_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdRoute()
    {
        return $this->hasOne(TRoute::className(), ['id' => 'id_route']);
    }
}
