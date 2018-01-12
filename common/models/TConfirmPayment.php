<?php

namespace common\models;

use Yii;

use yii\helpers\FileHelper;
/**
 * This is the model class for table "t_confirm_payment".
 *
 * @property integer $id
 * @property integer $name
 * @property integer $amount
 * @property string $proof_payment
 * @property string $note
 * @property integer $datetime
 *
 * @property TPayment $id0
 */
class TConfirmPayment extends \yii\db\ActiveRecord
{
     public $imageFiles;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_confirm_payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'amount'], 'required'],
            [['datetime'],'default','value'=>date('Y-m-d')],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
            [['id', 'amount', 'datetime'], 'integer'],
            [['proof_payment', 'note'], 'string'],
            [[ 'name'],'string','max'=>50],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => TPayment::className(), 'targetAttribute' => ['id' => 'id']],
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
            'amount' => Yii::t('app', 'Amount'),
            'proof_payment' => Yii::t('app', 'Proof Payment'),
            'note' => Yii::t('app', 'Note'),
            'datetime' => Yii::t('app', 'Datetime'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTPayment()
    {
        return $this->hasOne(TPayment::className(), ['id' => 'id']);
    }

    public function uploadProof()
    {
        $basepath = Yii::getAlias('@frontend').'/payment-files/payment-confirm/'.$this->id.'/';
        FileHelper::createDirectory($basepath, $mode = 0777, $recursive = true);
        $this->imageFiles->saveAs($basepath.$this->imageFiles->baseName . '.' . $this->imageFiles->extension);
        $this->proof_payment = $basepath.$this->imageFiles->baseName . '.' . $this->imageFiles->extension;
        return true;
    }
}
