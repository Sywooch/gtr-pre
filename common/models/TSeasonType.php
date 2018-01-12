<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_season_type".
 *
 * @property integer $id
 * @property string $season
 *
 * @property TSeasonPrice[] $tSeasonPrices
 */
class TSeasonType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_season_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['season'], 'required'],
            [['season'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'season' => Yii::t('app', 'Season'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTSeasonPrices()
    {
        return $this->hasMany(TSeasonPrice::className(), ['id_season_type' => 'id']);
    }

    public function getTSeasonSets()
    {
        return $this->hasMany(TSeasonPriceSet::className(), ['id_season_type' => 'id']);
    }
}
