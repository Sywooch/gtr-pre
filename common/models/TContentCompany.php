<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_content_company".
 *
 * @property integer $id
 * @property integer $id_company
 * @property integer $id_content
 * @property string $datetime
 *
 * @property TCompany $idCompany
 * @property TContent $idContent
 */
class TContentCompany extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_content_company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_company'], 'required'],
            [['id_company', 'id_content'], 'integer'],
            [['datetime'], 'safe'],
            [['id_company'], 'exist', 'skipOnError' => true, 'targetClass' => TCompany::className(), 'targetAttribute' => ['id_company' => 'id']],
            [['id_content'], 'exist', 'skipOnError' => true, 'targetClass' => TContent::className(), 'targetAttribute' => ['id_content' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_company' => Yii::t('app', 'Company'),
            'id_content' => Yii::t('app', 'Content'),
            'datetime' => Yii::t('app', 'Datetime'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCompany()
    {
        return $this->hasOne(TCompany::className(), ['id' => 'id_company']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdContent()
    {
        return $this->hasOne(TContent::className(), ['id' => 'id_content']);
    }
}
