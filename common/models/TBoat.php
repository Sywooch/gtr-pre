<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_boat".
 *
 * @property integer $id
 * @property integer $id_company
 * @property string $name
 *
 * @property TCompany $idCompany
 * @property TTrip[] $tTrips
 */
class TBoat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_boat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_company', 'name'], 'required'],
            [['id_company'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['id_company'], 'exist', 'skipOnError' => true, 'targetClass' => TCompany::className(), 'targetAttribute' => ['id_company' => 'id']],
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
            'name' => Yii::t('app', 'Boat Name'),
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
    public function getTTrips()
    {
        return $this->hasMany(TTrip::className(), ['id_boat' => 'id']);
    }
}
