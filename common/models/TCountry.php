<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_country".
 *
 * @property string $id
 * @property string $name
 *
 * @property TVisitor[] $tVisitors
 */
class TCountry extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['id'], 'string', 'max' => 2],
            [['name'], 'string', 'max' => 50],
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
    public function getTVisitors()
    {
        return $this->hasMany(TVisitor::className(), ['id_country' => 'id']);
    }
}
