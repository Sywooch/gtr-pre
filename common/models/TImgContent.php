<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_img_content".
 *
 * @property integer $id
 * @property string $name
 * @property string $path
 * @property integer $id_content
 *
 * @property TContent $idContent
 */
class TImgContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_img_content';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'path', 'id_content'], 'required'],
            [['path'], 'string'],
            [['id_content'], 'integer'],
            [['name'], 'string', 'max' => 50],
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
            'name' => Yii::t('app', 'Name'),
            'path' => Yii::t('app', 'Path'),
            'id_content' => Yii::t('app', 'Id Content'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdContent()
    {
        return $this->hasOne(TContent::className(), ['id' => 'id_content']);
    }
}
