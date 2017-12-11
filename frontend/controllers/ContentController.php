<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\TContent;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use common\models\TGalery;
use yii\imagine\Image;
use yii\helpers\FileHelper;

/**
 * Content controller
 */
class ContentController extends Controller
{
	public $defaultAction = 'index';

	public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['view'],
                'rules' => [
    
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'view' => ['get'],
                ],
            ],
        ];
	}

    public function actionAjaxThumbnail($slug){
       // if (Yii::$app->request->isAjax) {
            // $data = Yii::$app->request->post();
            return $this->renderAjax('/img-manager/ajax-image',['slug'=>$slug]);
       // }
    }

    //  public function actionThumbnail($slug)
    // {
    //     $model = $this->findModelArray($slug);
    //     $response = Yii::$app->getResponse();
    //     return $response->sendFile($model['thumbnail'],'thumbnail.jpg', [
    //             //'mimeType' => 'image/jpg',
    //            //'fileSize' => '386',
    //             'inline' => true
    //     ]);
    // }

    public function actionThumbnail($slug,$mode = 3)
    {
        //mode 1 = tumbnail 300x 300
        //mode 2 = thumbnail 1024 X 640
        // mode 3 = no resize
        $model = $this->findModelArray($slug);
        $path = Yii::$app->basePath."/web/content-img/".$model['slug']."/";
        if ($mode == 1) {

            $filename = "thumbnail-300.png";
            $filePath = $this->resizeImage($model['thumbnail'],$filename,300,300,50,$path);

        }elseif ($mode == 2) {
            
            $filename = "thumbnail-1024.png";
            $filePath = $this->resizeImage($model['thumbnail'],$filename,1024,640,50,$path);

        }else{
            
            $filename = "header.png";
            $filePath = $this->resizeImage($model['thumbnail'],$filename,1024,640,75,$path);

        }
        $response = Yii::$app->getResponse();
        return $response->sendFile($filePath,'thumbnail.png', [
                //'mimeType' => 'image/jpg',
               //'fileSize' => '386',
                'inline' => true
        ]);
    }

    protected function resizeImage($model,$filename,$width,$height,$quality,$path){
        if (!file_exists($path.$filename)){
            FileHelper::createDirectory($path, $mode = 0775, $recursive = true);
            Image::thumbnail($model, $width, $height)
                ->save($path.$filename, ['quality' => $quality]);
            }
        return $path.$filename;
    }


     protected function findModelArray($slug)
    {
        if (($model = TContent::find()->where(['slug'=>$slug])->asArray()->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGalery($id){
        $modelGalery = $this->findOneGalery($id);
        $response = Yii::$app->getResponse();
        return $response->sendFile($modelGalery['filename'],$modelGalery['name'], [
                //'mimeType' => 'image/jpg',
               'fileSize' => $modelGalery['size'],
                'inline' => true
        ]);
    }
    protected function findOneGalery($id){
        return TGalery::find()->where(['id'=>$id])->asArray()->one();
    }

	 public function actionView($slug)
    {
        return $this->render('view', [
            'model' => $this->findOneBySlug($slug),
        ]);
    }

    public function actionHotels(){
       $listContent = $this->findByType('9');

        return $this->render('content', [
            'listContent'=>$listContent,
        ]);
    }

    public function actionTermsConditions(){
        $contentTC = $this->findOneByType('10');
        return $this->render('term', [
            'model'=>$contentTC,
        ]);
    }
    public function actionPrivacyPolicy(){
        $contentTC = $this->findOneByType('11');
        return $this->render('term', [
            'model'=>$contentTC,
        ]);
    }

    public function actionFastBoats(){
    	$listContent = $this->findByType('1');

    	return $this->render('content', [
            'listContent'=>$listContent,
        ]);
    }

     public function actionPorts(){
        $listContent = $this->findByType('2');
        if (empty($listContent)) {
            return $this->goHome();
        }else{
        return $this->render('content', [
            'listContent'=>$listContent,
        ]);
        }
    }

    public function actionDestinations(){
    	$listContent = $this->findByType('3');
    	if (empty($listContent)) {
    		return $this->goHome();
    	}else{
    	return $this->render('content', [
            'listContent'=>$listContent,
        ]);
    	}
    }

    public function actionArticles(){
        $listContent = $this->findByType('4');
        if (empty($listContent)) {
            return $this->goHome();
        }else{
        return $this->render('content', [
            'listContent'=>$listContent,
        ]);
        }
    }
   

    public function actionIndex()
    {
    	$listContent = TContent::find()->all();
        return $this->render('content', [
            'listContent'=>$listContent,
        ]);
    }

    protected function findByType($type){
    	return TContent::find()->where(['id_type_content'=>$type])->all();
    }
    protected function findOneByType($type){
        return TContent::find()->where(['id_type_content'=>$type])->asArray()->one();
    }


    protected function findOneBySlug($slug){
        if (($model = TContent::find()->joinWith(['idTypeContent','galeris','author0'])->where(['slug'=>$slug])->asArray()->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('This Page is broken or under Development');
        }
    }


    protected function findModel($slug)
    {
        if (($model = TContent::findOne(['slug'=>$slug])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}