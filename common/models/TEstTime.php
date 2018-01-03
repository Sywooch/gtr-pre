<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_est_time".
 *
 * @property integer $id
 * @property string $est_time
 */
class TEstTime extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_est_time';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['est_time'], 'required'],
            [['est_time'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'est_time' => Yii::t('app', 'Est Time'),
        ];
    }
}
