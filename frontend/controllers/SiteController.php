<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
//use common\models\LoginForm;
use common\models\THarbor;
use common\models\TRoute;
use common\models\TTrip;
use common\models\TKurs;
use common\models\TCompany;
use common\models\TCart;
use common\models\TContent;
use frontend\models\BookForm;
use frontend\models\Hotel;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\TripSearching;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use kartik\widgets\Growl;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            // 'access' => [
            //     'class' => AccessControl::className(),
            //     'only' => ['logout', 'signup'],
            //     'rules' => [
            //         [
            //             'actions' => ['signup','to-port'],
            //             'allow' => true,
            //             'roles' => ['?'],
            //         ],
            //         [
            //             'actions' => ['logout'],
            //             'allow' => true,
            //             'roles' => ['@'],
            //         ],
            //     ],
            // ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

     public function beforeAction($action)
    {    
       if ($action->id == 'result') {

            $this->enableCsrfValidation = false;
            return true;
        }else{
          return true;
        }    
    }

    public function actionTracking(){
      if (Yii::$app->request->isAjax) {
        $url = Yii::$app->request->post('url');
        Yii::$app->gilitransfers->trackFrontendVisitor($url); 
      }
    }

    protected function findCart(){
        return TCart::find();
    }
    
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    protected function findOneTripAsArray($id){
        return TTrip::find()->joinWith(['idBoat.idCompany','idRoute.departureHarbor as departure','idRoute.arrivalHarbor','idEstTime'])->where(['t_trip.id'=>$id])->asArray()->one();
    }

    public function actionDetailModal(){
        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->post();
            $tripDeparture = $this->findOneTripAsArray($data['deptv']);
            $session =  $session = Yii::$app->session;
            $paxAdult = $session['formData']['adults'];
            $paxChild = $session['formData']['childs'];
            $currency = $this->findOneKursAsArray($session['formData']['currency']);
            if ($data['retv'] != 'false') {
               $tripReturn    = $this->findOneTripAsArray($data['retv']);
               return $this->renderAjax('detail-modal',[
                        'tripDeparture'=>$tripDeparture,
                        'tripReturn'=>$tripReturn,
                        'currency'=>$currency,
                        'session'=>$session,
                        'paxAdult'=>$paxAdult,
                        'paxChild'=>$paxChild,
                        ]);
            }else{
                return $this->renderAjax('detail-modal-one',[
                        'tripDeparture'=>$tripDeparture,
                        'currency'=>$currency,
                        'session'=>$session,
                        'paxAdult'=>$paxAdult,
                        'paxChild'=>$paxChild,
                        ]);
            }
        }
    }

    public function actionLogo($id)
    {
        $model = TCompany::findOne($id);
        $response = Yii::$app->getResponse();
        return $response->sendFile($model->logo_path,'thumbnail.jpg', [
                //'mimeType' => 'image/jpg',
               //'fileSize' => '386',
                'inline' => true
        ]);
    }


    protected function findHarbor(){
        return THarbor::find();
    }

    protected function findKurs(){
        return TKurs::find();
    }

    protected function findOneKursAsArray($currency){
        return TKurs::find()->where(['currency'=>$currency])->asArray()->one();
    }
    public function actionToPort(){
        if(Yii::$app->request->isAjax){
            $data =  Yii::$app->request->post();
            $from = $data['fromv'];

           // $route = TRoute::find();
            $dept = $this->findHarbor()->where(['id'=>$from])->one();
            $return = THarbor::find()->where('id_island != :id_island',[':id_island'=>$dept->id_island])->all();
            foreach ($return as $key => $value) {
                echo "<option value=".$value->id.">".$value->name."</option>";
                     
            }
        }
    }
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $session =Yii::$app->session;
        $modelBookForm = new BookForm();
        
         if ($modelBookForm->load(Yii::$app->request->post()) && $modelBookForm->validate()){
            if ($modelBookForm->type == true) {
                 $formData = [
                    'departurePort' =>$modelBookForm->departurePort,
                    'arrivalPort'   =>$modelBookForm->arrivalPort,
                    'departureDate' =>$modelBookForm->departureDate,
                    'returnDate'    =>$modelBookForm->returnDate,
                    'adults'        =>$modelBookForm->adults,
                    'childs'        =>$modelBookForm->childs,
                    'infants'       =>$modelBookForm->infants,
                    'type'          =>'2',
                    'currency'      =>$modelBookForm->currency
                ];
                
            }else{
                $formData = [
                    'departurePort' =>$modelBookForm->departurePort,
                    'arrivalPort'   =>$modelBookForm->arrivalPort,
                    'departureDate' =>$modelBookForm->departureDate,
                    'adults'        =>$modelBookForm->adults,
                    'childs'        =>$modelBookForm->childs,
                    'infants'       =>$modelBookForm->infants,
                    'type'          =>'1',
                    'currency'      =>$modelBookForm->currency
                    
                ];
               
            }/*else{
                $session            = session_unset();
                return $this->goHome();
            }*/

            $session->open();
            $session['timeout'] = date('d-m-Y H:i:s');
            $session->close();
            
            return $this->redirect(['result','BookForm'=>$modelBookForm]);
            //,'formData'=>$formData
      }else{
        if ($session['route'] == 'none') {
           // $session      = session_unset();
            echo Growl::widget([
              'type' => Growl::TYPE_DANGER,
              'title' => 'SORRY!',
              'icon' => 'glyphicon glyphicon-remove',
              'body' => 'Current Route Is Unavaible, Please Select Other Route Or Contact US',
              'showSeparator' => true,
              'delay' => 500,
              'pluginOptions' => [
              'showProgressbar' => true,
              'placement' => [
              'from' => 'top',
              'align' => 'center',
              ]
              ]
            ]);
            $session->remove('route');
        }

        if ($session['timeout'] == 'timeout') {
           // $session      = session_unset();
            echo Growl::widget([
              'type' => Growl::TYPE_DANGER,
              'title' => 'SORRY!',
              'icon' => 'glyphicon glyphicon-remove',
              'body' => 'Your Session has been Timeout, Please Reorder Your Trip Again',
              'showSeparator' => true,
              'delay' => 500,
              'pluginOptions' => [
              'showProgressbar' => true,
              'placement' => [
              'from' => 'top',
              'align' => 'center',
              ]
              ]
            ]);
            $session->remove('payment');
            $session->remove('timeout');
        }elseif($session['timeout'] == 'confirm'){
            echo Growl::widget([
              'type' => Growl::TYPE_SUCCESS,
              'title' => 'Thank You!',
              'icon' => 'glyphicon glyphicon-check',
              'body' => 'Your confirmation is being processed, we will contact you soon',
              'showSeparator' => true,
              'delay' => 500,
              'pluginOptions' => [
              'showProgressbar' => true,
              'placement' => [
              'from' => 'top',
              'align' => 'center',
              ]
              ]
            ]);
            $session->remove('payment');
            $session->remove('timeout');
        }
        $listBoats = TContent::find()->where(['id_type_content'=>1])->asArray()->orderBy(['updated_at'=>SORT_DESC])->limit(4)->all();
        $listPorts = TContent::find()->where(['id_type_content'=>2])->asArray()->orderBy(['updated_at'=>SORT_DESC])->limit(4)->all();
        $listDestinations = TContent::find()->where(['id_type_content'=>3])->asArray()->orderBy(['updated_at'=>SORT_DESC])->limit(4)->all();
        $keywordPuller = TContent::find(['id_type_content'=>5])->asArray()->one();
        $listArticle = TContent::find()->where(['id_type_content'=>4])->asArray()->orderBy(['updated_at'=>SORT_DESC])->limit(4)->all();
        return $this->render('index',[
            'listBoats'=>$listBoats,
            'listDestinations'=>$listDestinations,
            'listPorts'=>$listPorts,
            'listArticle'=>$listArticle,
            'keywordPuller'=>$keywordPuller,
            ]);
      }
    }

    protected function findRoute($departure,$return){
     return TRoute::find()->where(['departure'=>$departure])->andWhere(['arrival'=>$return])->asArray()->one();
    }

    protected function findTrip($date,$formData,$route){
        $totalPax = $formData['adults']+$formData['childs'];
        return TTrip::find()
        ->joinWith(['idBoat.idCompany','idRoute.departureHarbor AS Departure','idRoute.arrivalHarbor','idEstTime'])
        ->where(['date'=>$date])
        ->andWhere(['id_route'=>$route['id']])
        ->andWhere('t_trip.id_price_type IS NOT :priceid',['priceid'=>null])
        ->andWhere('t_trip.stock >= :totalPax',[':totalPax'=>$totalPax])
        ->andWhere(['status'=>1])
        ->asArray()
        ->all();
    }

    protected function findTripAllBali($date,$formData,$route){
        $totalPax = $formData['adults']+$formData['childs'];
      foreach ($route as $keyRoute => $valRoute) {
        $Trips [] = TTrip::find()
        ->where(['date'=>$date])
        ->andWhere(['id_route'=>$valRoute->id])
        ->andWhere('id_price_type IS NOT :priceid',['priceid'=>null])
        ->andWhere('stock >= :totalPax',[':totalPax'=>$totalPax])
        ->andWhere(['status'=>1])
        ->all();
      }
      return $Trips;
         
    }
    protected function findRouteToBali($departure){
      return TRoute::find()->joinWith('arrivalHarbor')->where(['t_harbor.id_island'=>1])->andWhere(['departure'=>$departure])->all();
    }
    protected function findRouteFromBali($arrival){
      return TRoute::find()->joinWith('departureHarbor')->where(['t_harbor.id_island'=>1])->andWhere(['arrival'=>$arrival])->all();
    }

    public function actionResult(){
         $session =Yii::$app->session;
         $session->open();
         $modelBookForm = new BookForm();
         $modelBookForm->load(Yii::$app->request->get());
      if ($modelBookForm->validate()){
         $formData = Yii::$app->request->get('BookForm');
         $session['formData'] = $formData;
         $currency = $this->findOneKursAsArray($formData['currency']);
         $totalPax = $formData['adults']+$formData['childs'];
         if (($routeDeparture = $this->findRoute($formData['departurePort'],$formData['arrivalPort'])) !== null) {
            $departureList  = $this->findTrip($formData['departureDate'],$formData,$routeDeparture);
            // false One Way true Return
            if ($formData['type'] == true) {
                $routeReturn    = $this->findRoute($formData['arrivalPort'],$formData['departurePort']);
                $returnList     = $this->findTrip($formData['returnDate'],$formData,$routeReturn);
                return $this->render('result',[
                'formData'      => $formData,
                'departureList' => $departureList,
                'returnList'    => $returnList,
                'currency'      => $currency,
                'totalPax'      => $totalPax,
                'session'       => $session,
            
                ]);
            }elseif ($formData['type'] == false) {
                    
                return $this->render('result-one',[
                'formData'      => $formData,
                'departureList' => $departureList,
                'currency'      => $currency,
                'totalPax'      => $totalPax,
                'session'       => $session,
            
                ]);
            }else{
                return $this->goHome();
            }
         }else{
            $session['route'] = 'none';
            return $this->goHome();
         }
      }else{
            return $this->goHome();
         }
        
        
    }


    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
       $content = $this->findOneContent(6);
        return $this->render('about',['content'=>$content]);
    }

    public function actionHowToBook()
    {
       $content = $this->findOneContent(7);
        return $this->render('about',[
                'content'=>$content,
                ]);
    }
    public function actionFaq()
    {
       $content = TContent::find()->where(['id_type_content'=>8])->orderBy(['updated_at'=>SORT_DESC])->all();
        return $this->render('/faq/index',['content'=>$content]);
    }

    protected function findOneContent($id_type){
      return TContent::findOne(['id_type_content'=>$id_type]);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
   /* public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    /*public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    /*public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }*/
}
