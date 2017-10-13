<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_type_content".
 *
 * @property integer $id
 * @property string $type
 *
 * @property TContent[] $tContents
 */
class TTypeContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_type_content';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTContents()
    {
        return $this->hasMany(TContent::className(), ['id_type_content' => 'id']);
    }
}
