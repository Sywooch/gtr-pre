<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_webhook_event".
 *
 * @property integer $id
 * @property string $event
 * @property string $datetime
 *
 * @property TWebhook[] $tWebhooks
 */
class TWebhookEvent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_webhook_event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event'], 'required'],
            [['datetime'], 'safe'],
            [['event'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'event' => Yii::t('app', 'Event'),
            'datetime' => Yii::t('app', 'Datetime'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTWebhooks()
    {
        return $this->hasMany(TWebhook::className(), ['id_event' => 'id']);
    }

    public static function checkEvent($Event){
        if (($modelEvent = TWebhookEvent::find()->where(['event'=>$Event])->asArray()->one()) !== null) {
            return $modelEvent['id'];
        }else{
            $modelEvent        = new TWebhookEvent();
            $modelEvent->event = $Event;
            $modelEvent->save(false);
            return $modelEvent->id;
        }
    }
}
