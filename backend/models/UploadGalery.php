<?php 
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;
use yii\helpers\FileHelper;

class UploadGalery extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $imageFiles;

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 50],
        ];
    }
    
    public function upload()
    {
                $basepath = Yii::getAlias('@backend').'/contentImage/fasboat/';
                FileHelper::createDirectory($basepath, $mode = 0775, $recursive = true);
                $this->imageFiles->saveAs($basepath. $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
    }
}