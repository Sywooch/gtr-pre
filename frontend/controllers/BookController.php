<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use common\models\LoginForm;
use common\models\THarbor;
use common\models\TRoute;
use common\models\TTrip;
use common\models\TKurs;
use common\models\TCompany;
use common\models\TPaymentDetail;
use common\models\TPayment;
use common\models\TCart;
use common\models\TAvaibility;
use common\models\TPassenger;
use common\models\TPassengerChildInfant;
use common\models\TPassengerType;
use common\models\TBooking;
use common\models\TShuttleLocationTmp;
use common\models\TShuttleArea;
use common\models\TMailQueue;
use frontend\models\PaymentModel;
use common\models\TNationality;
use \yii\base\Model;
use kartik\mpdf\Pdf;
use yii\helpers\FileHelper;
use yii\web\Response;
/**
 * Site controller
 */
class BookController extends Controller
{

	 public function behaviors()
    {
        
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'add-to-cart' => ['post'],
                    'remove-cart' => ['post'],
                ],
            ],
        ];
    }

  public function beforeAction($action){
    $session       = Yii::$app->session;
    if ($action->id != 'add-to-cart') {
        if ($session['timeout'] < date('Y-m-d H:i:s') || $session['timeout'] == null) {
          $cartList = $this->findCartBySessionKey()->all();
          if (!empty($cartList)) {
              foreach ($cartList as $key => $value) {
              $this->removeCart($value->id);
              }
              $session['timeout'] = 'timeout';
            return $this->goHome()->send();
          }
            return true;
        }else{
          return true;
        }
    }else{
         return true;
    }
  }

    protected function removeCart($id){

        $modelCart       = $this->findCart($id);
       // $modelAvaibility = $this->findAvaibility()->where(['id_trip'=>$modelCart->id_trip])->one();
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $totalPax        = $modelCart->adult+$modelCart->child;
             $trip = TTrip::find()->joinWith('idRoute.arrivalHarbor')->joinWith('idBoat')->andWhere('t_route.departure = :departure',['departure'=>$modelCart->idTrip->idRoute->departure])->andWhere('t_harbor.id_island = :id_island',['id_island'=>$modelCart->idTrip->idRoute->arrivalHarbor->id_island])->andWhere('t_boat.id_company = :id_company',[':id_company'=>$modelCart->idTrip->idBoat->id_company])->andWhere(['date'=>$modelCart->idTrip->date])->all();
             foreach ($trip as $key => $valTrip) {
                $valTrip->stock = $valTrip->stock+$totalPax;
                $valTrip->validate();
                $valTrip->save(false);
             }
            $modelCart->delete();
            $transaction->commit();
        } catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
        
    }

    protected function findCartBySessionKey(){
        $session       = Yii::$app->session;
        return TCart::find()->where(['session_key'=>$session['session_key']]);
    }

    protected function findShuttleLocation(){
        return TShuttleArea::find()->all();
    }

    public function actionDetailData(){
    $session       = Yii::$app->session;
    $cartList        = $this->findCartBySessionKey()->orderBy(['id'=>SORT_ASC])->all();
    $helperAdult     = ArrayHelper::map($cartList, 'id_trip', 'adult', 'id_trip');
    $helperChild     = ArrayHelper::map($cartList, 'id_trip', 'child', 'id_trip');
    $helperInfant    = ArrayHelper::map($cartList, 'id_trip', 'infant', 'id_trip');
    $listPickup      = ArrayHelper::map(TShuttleArea::find()->asArray()->all(), 'id', 'area');
    $modelShuttle    = [new TShuttleLocationTmp()];
    $modelPayment    = new TPaymentDetail();
    $modelAdults     = [new TPassenger()];
    $modelChilds     = [new TPassengerChildInfant()];
    $modelInfants    = [new TPassengerChildInfant()];
    $listNationality = ArrayHelper::map(TNationality::find()->asArray()->all(), 'id', 'nationality');

    if ($modelPayment->load(Yii::$app->request->post())) {
       $transaction = Yii::$app->db->beginTransaction();
       try {
        $expired_time = date('Y-m-d H:i:s', strtotime('+2 HOURS'));
        $modelPayment->token = $modelPayment->generatePaymentToken("token");
        $modelPayment->exp = $expired_time;
        $modelPayment->currency = $cartList[0]['currency'];
        $modelPayment->exchange = $cartList[0]['exchange'];
        $modelPayment->validate();
        $modelPayment->save(false);
        
        //$token = Yii::$app->getSecurity()->generateRandomString(25);
       // $saveCustomer->name = 
           foreach ($cartList as $key => $cartValue) {
                 $adultPrice               = round($cartValue->idTrip->adult_price/$cartValue->exchange*$cartValue->adult,0,PHP_ROUND_HALF_UP);
                 $childPrice               = round($cartValue->idTrip->child_price/$cartValue->exchange*$cartValue->child,0,PHP_ROUND_HALF_UP);
                 $saveBooking               = new TBooking();
                 $saveBooking->id           = $saveBooking->generateBookingNumber("id");
                 $saveBooking->id_trip      = $cartValue->id_trip;
                 $saveBooking->id_payment   = $modelPayment->id;
                 $saveBooking->trip_price   = $adultPrice+$childPrice;
                 $saveBooking->total_price  = $adultPrice+$childPrice;
                 $saveBooking->currency     = $cartValue->currency;
                 $saveBooking->total_idr    = $cartValue->idTrip->adult_price*$cartValue->adult + $cartValue->idTrip->child_price*$cartValue->child;
                 $saveBooking->exchange     = $cartValue->exchange;
                 $saveBooking->expired_time = $expired_time;
                 $saveBooking->validate();
                 $saveBooking->save(false);
                 
                 $loadShuttle               = Yii::$app->request->post('TShuttle');
                 $loadPassengersAdult       = Yii::$app->request->post('TPassenger');
                 $loadPassengersChildInfant = Yii::$app->request->post('TPassengerChildInfant');

                foreach ($loadPassengersAdult[$cartValue->id_trip]['adult'] as $x => $value) {
                         $saveAdult                 = new TPassenger();
                         $saveAdult->id_booking     = $saveBooking->id;
                         $saveAdult->name           = $value['name'];
                         $saveAdult->id_nationality = $value['id_nationality'];
                         $saveAdult->id_type        = $saveAdult::TYPE_ADULT;
                         $saveAdult->validate();
                         $saveAdult->save(false);       
                }
                if (!empty($loadPassengersChildInfant[$cartValue->id_trip]['child'])) {
                    foreach ($loadPassengersChildInfant[$cartValue->id_trip]['child'] as $x => $valueChild) {
                         $saveChild                 = new TPassengerChildInfant();
                         $saveChild->id_booking     = $saveBooking->id;
                         $saveChild->name           = $valueChild['name'];
                         $saveChild->id_nationality = $valueChild['id_nationality'];
                         $saveChild->birthday       = $valueChild['birthday'];
                         $saveChild->id_type        = $saveChild::TYPE_CHILD;
                         $saveChild->validate();
                         $saveChild->save(false);       
                }
                }
                
                if (!empty($loadPassengersChildInfant[$cartValue->id_trip]['infant'])) {
                    foreach ($loadPassengersChildInfant[$cartValue->id_trip]['infant'] as $x => $valueInfant) {
                         $saveInfant                 = new TPassengerChildInfant();
                         $saveInfant->id_booking     = $saveBooking->id;
                         $saveInfant->name           = $valueInfant['name'];
                         $saveInfant->id_nationality = $valueInfant['id_nationality'];
                         $saveInfant->birthday       = $valueInfant['birthday'];
                         $saveInfant->id_type        = $saveInfant::TYPE_INFANT;
                         $saveInfant->validate();
                         $saveInfant->save(false);       
                    }
                }
                
                $loadShuttle =  Yii::$app->request->post('TShuttleLocationTmp');
                if (!empty($loadShuttle[$cartValue->id_trip]['id_area'])) {
                    $saveShuttle                = new TShuttleLocationTmp();
                    $saveShuttle->id_booking    = $saveBooking->id;
                    $saveShuttle->id_area       = $loadShuttle[$cartValue->id_trip]['id_area'];
                    $saveShuttle->type          = $loadShuttle[$cartValue->id_trip]['type'];
                    $saveShuttle->location_name = $loadShuttle[$cartValue->id_trip]['location_name'];
                    $saveShuttle->address       = $loadShuttle[$cartValue->id_trip]['address'];
                    $saveShuttle->phone         = $loadShuttle[$cartValue->id_trip]['phone'] != null ? $loadShuttle[$cartValue->id_trip]['phone'] : null;
                    $saveShuttle->validate();
                    $saveShuttle->save(false) ;
                }
            $payment[]     = $saveBooking->total_price;
            $payment_idr[] = $saveBooking->total_idr;
            $cartValue->delete();
            
         }
            $modelPayment->total_payment     = array_sum($payment);
            $modelPayment->total_payment_idr = array_sum($payment_idr);
            $modelPayment->save();
            $session                         = session_unset();
            $session                         = Yii::$app->session;
            $session->open();
            $session['cust_id']              = $modelPayment->id;
            $session['token']                = $modelPayment->token;
            $session['timeout']              = 'on-payment';
            $session->close();
            $transaction->commit();
       } catch(\Exception $e) {
           $transaction->rollBack();
           throw $e;
       }

       return $this->redirect(['payment']);

    }

    	return $this->render('detail-data',[
                'cartList'=>$cartList,
                'modelPayment'=>$modelPayment,
                'modelAdults'=> (empty($modelAdults)) ? [[new TPassenger]] : $modelAdults,
                'modelChilds'=>$modelChilds,
                'modelInfants'=>$modelInfants,
                'helperAdult'=>$helperAdult,
                'listNationality'=>$listNationality,
                'listPickup'=>$listPickup,
                'modelShuttle'=>$modelShuttle,

                ]);
    }

    public function actionPayment(){
        $session      = Yii::$app->session;
        $modelPayment  = $this->findPayment($session['token']);
        $modelBooking = $modelPayment->tBookings;

        if ($modelPayment->load(Yii::$app->request->post()) && $modelPayment->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                  $modelPayment->setPaymentBookingStatus($modelPayment::STATUS_UNCONFIRMED,$modelPayment::STATUS_PENDING);
                  //PAYMENT STATUS 1 BOOKING UNPAID (2)
                  $modelPayment->save(false);
                  $modelPayment->save();
                  $modelQueue         = TMailQueue::addInvoiceQueue($modelPayment->id);
                  $transaction->commit();
                  $session         = session_unset();
                  $session            = Yii::$app->session;
                  $session->open();
                  $session['payment'] = 'sukses';
                 return $this->redirect(['thank-you']); 
            } catch(\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
           

        }else{
            $this->layout = 'payment';
            return $this->render('payment',[
                'modelPayment'=>$modelPayment,
                ]);
        }

    }

    protected function findPayment($token){
        if (($payment = TPayment::findOne(['token'=>$token])) !== null) {
            return $payment;
        }else{
            throw new NotFoundHttpException('Data Not Found, Please Contact Us');
        }
    }

    public function actionPaypal(){
         $session       = Yii::$app->session;
         $modelpembayaranPaypal = $this->findPayment($session['token']);
         return $this->renderAjax('paypal',[
         'modelpembayaranPaypal'=>$modelpembayaranPaypal,
         ]);    
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


    public function actionThankYou(){
        $session = Yii::$app->session;
        if ($session['payment'] == 'sukses') {
            return $this->render('thank-you');
        }else{
            return $this->goHome();
        }
        
    }

    protected function findPassenger(){
        return TPassenger::find();
    }

    protected function findShuttle(){
        return TShuttleLocationTmp::find();
    }

    protected function findPaymentByToken($token){
        $tokenval = Yii::$app->getSecurity()->unmaskToken($token);
        if (($model = TPayment::findOne(['token'=>$tokenval])) !== null) {
            return $model;
        }else{
             throw new NotFoundHttpException('Token Not Found, Please Contact Us');
        }
    }

    protected function findBookingByPayment($id_payment){
        return TBooking::find()->where(['id_payment'=>$id_payment])->all();
    }

    protected function findTrip($id){
        return TTrip::findOne($id);
    }


    protected function addTripToCart($session,$id){
        $transaction = Yii::$app->db->beginTransaction();
        $currency = TKurs::find()->where(['currency'=>$session['formData']['currency']])->asArray()->one();
        try {
            if (($modelCart = TCart::find()->where(['session_key'=>$session['session_key']])->andWhere(['id_trip'=>$id])->one()) === null) {
                $modelCart               = new TCart();
                $modelCart->session_key  = $session['session_key'];
                $modelCart->id_trip      = $id;
                $modelCart->type         = $session['formData']['type'];
                $modelCart->adult        = $session['formData']['adults'];
                $modelCart->child        = $session['formData']['childs'];
                $modelCart->infant       = $session['formData']['infants'];
                $modelCart->currency     = $currency['currency'];
                $modelCart->exchange     = $currency['kurs'];
                $modelCart->start_time   = date('Y-m-d H:i:s');
                $modelCart->expired_time = date('Y-m-d H:i:s', strtotime('+30 minutes'));
                $modelCart->validate();
                $modelCart->save(false);
            }else{
               // $modelCart->type = $session['formData']['type'];
                $modelCart->session_key  = $session['session_key'];
                $modelCart->adult        = $modelCart->adult+$session['formData']['adults'];
                $modelCart->child        = $modelCart->child+$session['formData']['childs'];
                $modelCart->infant       = $modelCart->infant+$session['formData']['infants'];
                $modelCart->currency     = $currency['currency'];
                $modelCart->exchange     = $currency['kurs'];
                $modelCart->start_time   = date('Y-m-d H:i:s');
                $modelCart->expired_time = date('Y-m-d H:i:s', strtotime('+30 minutes'));
                $modelCart->validate();
                $modelCart->save(false);
            }
             
            $CartCurrency = TCart::find()->where(['session_key'=>$session['session_key']])->all();
                foreach ($CartCurrency as $n => $valCartCurrency) {
                    $valCartCurrency->currency = $currency['currency'];
                    $valCartCurrency->exchange = $currency['kurs'];
                    $valCartCurrency->save(false);
                }
             $totalPax                 = $modelCart->adult+$modelCart->child;
             $trip = TTrip::find()->joinWith('idRoute.arrivalHarbor')->joinWith('idBoat')->andWhere('t_route.departure = :departure',['departure'=>$modelCart->idTrip->idRoute->departure])->andWhere('t_harbor.id_island = :id_island',['id_island'=>$modelCart->idTrip->idRoute->arrivalHarbor->id_island])->andWhere('t_boat.id_company = :id_company',[':id_company'=>$modelCart->idTrip->idBoat->id_company])->andWhere(['date'=>$modelCart->idTrip->date])->all();
             foreach ($trip as $key => $valuetrip) {
                $valuetrip->stock = $valuetrip->stock-$totalPax;
                $valuetrip->process = $valuetrip->process+$totalPax;
                $valuetrip->validate();
                $valuetrip->save(false);
             }

             $transaction->commit();
        } catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
       
    }

    protected function findAffectedStock(){
        
    }

    protected function findAvaibility(){
        return TAvaibility::find();
    }
    public function actionAddToCart($tripDeparture,$tripReturn = null){
        $session = Yii::$app->session;
        $now = date('Y-m-d H:i:s');
        $session['timeout'] = date('Y-m-d H:i:s',strtotime('+ 30 MINUTES',strtotime($now)));
        if (!isset($session['session_key'])) {
            $session['session_key']= Yii::$app->getSecurity()->generateRandomString(25);
        }

        if ($tripDeparture!= null && $tripReturn == null) {
            $this->addTripToCart($session,$tripDeparture);
        }elseif ($tripDeparture != null && $tripReturn != null) {
            $this->addTripToCart($session,$tripDeparture);
            $this->addTripToCart($session,$tripReturn);
        }else{
            $session = session_unset();
            return $this->goHome();
        }
        
       return $this->redirect('detail-data');

    }

    protected function findCart($id){
         if (($model = TCart::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionRemoveCart($id){

        $modelCart       = $this->findCart($id);
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $totalPax        = $modelCart->adult+$modelCart->child;
             $trip = TTrip::find()->joinWith('idRoute.arrivalHarbor')->joinWith('idBoat')->andWhere('t_route.departure = :departure',['departure'=>$modelCart->idTrip->idRoute->departure])->andWhere('t_harbor.id_island = :id_island',['id_island'=>$modelCart->idTrip->idRoute->arrivalHarbor->id_island])->andWhere('t_boat.id_company = :id_company',[':id_company'=>$modelCart->idTrip->idBoat->id_company])->andWhere(['date'=>$modelCart->idTrip->date])->all();
             foreach ($trip as $key => $value) {
                
                $value->stock = $value->stock+$totalPax;
                $value->process = $value->process-$totalPax;
                $value->validate();
                $value->save(false);
             }
            $modelCart->delete();
            $transaction->commit();
        } catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
        

        return $this->redirect('detail-data');
    }

}

