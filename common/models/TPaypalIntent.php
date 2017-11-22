<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_paypal_intent".
 *
 * @property integer $id
 * @property string $intent
 *
 * @property TPaypalTransaction[] $tPaypalTransactions
 */
class TPaypalIntent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_paypal_intent';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['intent'], 'required'],
            [['id'], 'integer'],
            [['intent'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'intent' => Yii::t('app', 'Intent'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTPaypalTransactions()
    {
        return $this->hasMany(TPaypalTransaction::className(), ['id_intent' => 'id']);
    }

    public function checkIntent($intent){
        if (($modelIntent = TPaypalIntent::find()->where(['intent'=>$intent])->asArray()->one()) !== null) {
            return $modelIntent['id'];
        }else{
            $modelIntent = new TPaypalIntent();
            $modelIntent->intent = $intent;
            $modelIntent->save(false);
            return $modelIntent->id;
        }
    }
}
