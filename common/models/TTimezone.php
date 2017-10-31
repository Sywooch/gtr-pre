<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_timezone".
 *
 * @property integer $id
 * @property string $code
 * @property string $timezone
 *
 * @property TVisitor[] $tVisitors
 */
class TTimezone extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_timezone';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'timezone'], 'required'],
            [['code'], 'string', 'max' => 2],
            [['timezone'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Code'),
            'timezone' => Yii::t('app', 'Timezone'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTVisitors()
    {
        return $this->hasMany(TVisitor::className(), ['id_timezone' => 'id']);
    }
}
