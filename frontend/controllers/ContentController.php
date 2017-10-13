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
use common\models\TCart;


/**
 * Content controller
 */
class ContentController extends Controller
{
	public $defaultAction = 'index';

	public function behaviors(){
		$session       = Yii::$app->session;
        $cart = $this->findCart()->where(['session_key'=>$session['session_key']])->all();
        Yii::$app->view->params['countCart'] = count($cart);
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
        $model = $this->findModel($slug);
        $response = Yii::$app->getResponse();
        return $response->sendFile($model->thumbnail,'thumbnail.jpg', [
                //'mimeType' => 'image/jpg',
               //'fileSize' => '386',
                'inline' => true
        ]);
    }
	 public function actionView($slug)
    {
        return $this->render('view', [
            'model' => $this->findModel($slug),
        ]);
    }

    public function actionFastboats(){
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

    protected function findCart(){
        return TCart::find();
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