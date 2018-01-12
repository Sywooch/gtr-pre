<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_transport".
 *
 * @property integer $id
 * @property string $type
 * @property integer $pass_min
 * @property integer $pass_max
 */
class TTransport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_transport';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'pass_min', 'pass_max'], 'required'],
            [['pass_min', 'pass_max'], 'integer'],
            [['type'], 'string', 'max' => 15],
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
            'pass_min' => Yii::t('app', 'Pass Min'),
            'pass_max' => Yii::t('app', 'Pass Max'),
        ];
    }
}
