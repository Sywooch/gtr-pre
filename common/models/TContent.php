<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\FileHelper;    
/**
 * This is the model class for table "t_content".
 *
 * @property integer $id
 * @property integer $id_type_content
 * @property string $slug
 * @property string $title
 * @property string $content
 * @property integer $author
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property TTypeContent $idTypeContent
 * @property User $author0
 * @property TImgContent[] $tImgContents
 */
class TContent extends \yii\db\ActiveRecord
{
    public $thumb;

    public function behaviors() 
   { 
       return [ 
           TimestampBehavior::className(), 
       ]; 
   } 
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_content';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_type_content', 'slug', 'title', 'content','description','keywords'], 'required'],
            [['thumb'],'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, svg'],
            [['id_type_content', 'author'], 'integer'],
            [['content','thumbnail','description'], 'string'],
            [['author'],'default','value'=>Yii::$app->user->identity->id],
            [['slug', 'title'], 'string', 'max' => 50],
            [['title'], 'unique'],
            [['slug'], 'unique'],
            [['id_type_content'], 'exist', 'skipOnError' => true, 'targetClass' => TTypeContent::className(), 'targetAttribute' => ['id_type_content' => 'id']],
            [['author'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_type_content' => Yii::t('app', 'Type Content'),
            'slug' => Yii::t('app', 'Slug'),
            'title' => Yii::t('app', 'Title'),
            'keywords' => Yii::t('app', 'Keywords'),
            'content' => Yii::t('app', 'Content'),
            'author' => Yii::t('app', 'Author'),
            'thumb' => Yii::t('app', 'Thumbnail'),
            'thumbnail' => Yii::t('app', 'Thumbnail'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function saveThumbnail($slug)
    {

                $path = Yii::$app->basePath.'/posting/'.$slug.'/';
                FileHelper::createDirectory($path, $mode = 0777, $recursive = true);
                $this->thumb->saveAs($path.$this->thumb->baseName.'.'.$this->thumb->extension);
                $this->thumbnail = $path.$this->thumb->baseName.'.'.$this->thumb->extension;
                $this->save();
            return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTypeContent()
    {
        return $this->hasOne(TTypeContent::className(), ['id' => 'id_type_content']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor0()
    {
        return $this->hasOne(User::className(), ['id' => 'author']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTImgContents()
    {
        return $this->hasMany(TImgContent::className(), ['id_content' => 'id']);
    }
}
