<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_type_queue".
 *
 * @property integer $id
 * @property string $type
 *
 * @property TMailQueue[] $tMailQueues
 */
class TTypeQueue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_type_queue';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type'], 'string', 'max' => 10],
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
    public function getTMailQueues()
    {
        return $this->hasMany(TMailQueue::className(), ['id_type' => 'id']);
    }
}
