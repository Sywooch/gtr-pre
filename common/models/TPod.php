<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_pod".
 *
 * @property integer $id
 * @property string $name
 *
 * @property TCompany[] $tCompanies
 */
class TPod extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_pod';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTCompanies()
    {
        return $this->hasMany(TCompany::className(), ['id_pod' => 'id']);
    }
}
