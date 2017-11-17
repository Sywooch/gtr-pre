<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "t_galery".
 *
 * @property integer $id
 * @property string $name
 * @property string $filename
 * @property integer $size
 * @property integer $id_parent
 * @property integer $id_type_galery
 * @property string $datetime
 *
 * @property TTypeContent $idTypeGalery
 */
class TGalery extends \yii\db\ActiveRecord
{
    public $galery;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_galery';
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'filename', 'size', 'id_parent', 'id_type_galery'], 'required'],
            [['galery'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg','maxFiles'=>50],
            [['filename'], 'string'],
            [['size', 'id_parent', 'id_type_galery'], 'integer'],
            [['datetime'], 'safe'],
            [['name'], 'string', 'max' => 150],
            [['id_type_galery'], 'exist', 'skipOnError' => true, 'targetClass' => TTypeContent::className(), 'targetAttribute' => ['id_type_galery' => 'id']],
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
            'filename' => Yii::t('app', 'Filename'),
            'size' => Yii::t('app', 'Size'),
            'id_parent' => Yii::t('app', 'Id Parent'),
            'id_type_galery' => Yii::t('app', 'Id Type Galery'),
            'datetime' => Yii::t('app', 'Datetime'),
            'galery' => Yii::t('app', 'Image'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTypeGalery()
    {
        return $this->hasOne(TTypeContent::className(), ['id' => 'id_type_galery']);
    }
}
