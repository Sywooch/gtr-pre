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

     public function actionThumbnail($slug)
    {
         $this->layout = 'empty-layout';
        $model = $this->findModel($slug);
        $response = Yii::$app->getResponse();
        return $response->sendFile($model->thumbnail,'thumbnail.jpg', [
                //'mimeType' => 'image/jpg',
               //'fileSize' => '386',
                'inline' => true
        ]);
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
        if (($model = TContent::find()->joinWith(['idTypeContent','galeris'])->where(['slug'=>$slug])->asArray()->one()) !== null) {
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