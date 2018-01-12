<?php
namespace frontend\controllers;

use Yii;
use common\models\TPrivateCart;
use common\models\TPrivatePassenger;
use common\models\TNationality;
use common\models\TPayment;
use common\models\TPrivateBooking;
use common\models\TPassengerChildInfant;
use frontend\models\FlightForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use \yii\base\Model;

class PrivateBookingController extends Controller
{

  public function beforeAction($action){
    $session       = Yii::$app->session;

        if ($session['timeout'] < date('Y-m-d H:i:s') || $session['timeout'] == null) {
          $cartList = $this->findCartBySessionKey();
          if (!empty($cartList)) {
              foreach ($cartList as $key => $value) {
              $value->delete();
              }
              $session['timeout'] = 'timeout';
            return $this->goHome()->send();
          }
            return true;
        }else{
          return true;
        }
  }

  protected function findCartBySessionKey(){
        $session       = Yii::$app->session;
        return TPrivateCart::find()->where(['session_key'=>$session['session_key']])->all();
  }

  public function actionRemoveCart($id){
    if (Yii::$app->request->isPost) {
        $modelPrivateCart = $this->findOneCart($id);
        $modelPrivateCart->delete();
        return $this->redirect(['fill-detail']);

    }
  }

  protected function findOneCart($id){
    $session       = Yii::$app->session;
    if (($modelPrivateCart = TPrivateCart::find()->where(['session_key'=>$session['session_key'],'id'=>$id])->one()) !== null ) {
        return $modelPrivateCart;
    }else{
        throw new NotFoundHttpException('The requested page does not exist.');
    }
  }

	public function actionFillDetail(){
		$session            = Yii::$app->session;
		$cartList           = TPrivateCart::find()->where(['session_key'=>$session['session_key']])->orderBy(['id'=>SORT_ASC])->all();
		$helperAdult        = ArrayHelper::map($cartList, 'id_trip', 'adult', 'id_trip');
		$helperChild        = ArrayHelper::map($cartList, 'id_trip', 'child', 'id_trip');
		$helperInfant       = ArrayHelper::map($cartList, 'id_trip', 'infant', 'id_trip');
		$modelPayment       = new TPayment();
		$modelAdults        = [new TPrivatePassenger()];
		$modelChildsInfants = [new TPassengerChildInfant()];
		$listNationality    = ArrayHelper::map(TNationality::find()->asArray()->all(), 'id', 'nationality');
		if ($modelPayment->load(Yii::$app->request->post())) {
       $transaction = Yii::$app->db->beginTransaction();
       try {
		$expired_time           = date('Y-m-d H:i:s', strtotime('+2 HOURS'));
		$modelPayment->token    = $modelPayment->generatePaymentToken("token");
		$modelPayment->exp      = $expired_time;
		$modelPayment->currency = $cartList[0]['currency'];
		$modelPayment->id_payment_type = $modelPayment::PAYMENT_PRIV_TRANSFERS;
		$modelPayment->exchange = $cartList[0]['exchange'];
		$modelPayment->validate();
		$modelPayment->save(false);

           foreach ($cartList as $key => $cartValue) {

              $totalPax = $cartValue->adult+$cartValue->child;
              $maxPax = $cartValue->idTrip->max_person;
            

            if($totalPax <= $maxPax){
              $totalPrice = round($cartValue->idTrip->min_price/$cartValue->exchange,0,PHP_ROUND_HALF_UP);
              $totalPriceIdr = $cartValue->idTrip->min_price;
            }else{
               $minPrice = round($cartValue->idTrip->min_price/$cartValue->exchange,0,PHP_ROUND_HALF_UP);
               $extraPax = $totalPax-$maxPax;
               $extraPrice = round($cartValue->idTrip->person_price/$cartValue->exchange*$extraPax,0,PHP_ROUND_HALF_UP);
               $totalPrice = round($minPrice+$extraPrice,0,PHP_ROUND_HALF_UP);
               $extraPriceIdr = $cartValue->idTrip->person_price*$extraPax;
               $totalPriceIdr = $cartValue->idTrip->min_price+$extraPriceIdr;
        	}
        	$loadAdditionalInformation = Yii::$app->request->post('Note');
            if (($val =$loadAdditionalInformation[$cartValue->id_trip][date('Y-m-d',strtotime($cartValue->trip_date))][date('H:i',strtotime($cartValue->trip_date))]) != null) {
            	$note = $val;
            }else{
            	$note = null;
            }
            
                $dataPrivateBooking = [
                'id_payment' => $modelPayment->id,
                'id_trip'    => $cartValue->id_trip,
                'id_status'  => TPrivateBooking::STATUS_ON_BOOK,
                'amount'     => $totalPrice,
                'currency'   => $cartValue->currency,
                'amount_idr' => $totalPriceIdr,
                'date_trip'  => $cartValue->trip_date,
                'note'       => $note,	
                
                ];
                
                 $savePrivateBooking = TPrivateBooking::addPrivateBooking($dataPrivateBooking);


                 $loadPassengersAdult       = Yii::$app->request->post('TPrivatePassenger');
                 $loadPassengersChildInfant = Yii::$app->request->post('TPassengerChildInfant');

                foreach ($loadPassengersAdult[$cartValue->id_trip]['adult'] as $x => $value) {
                    $adultData = [
                    'id_booking'     => $savePrivateBooking,
                    'name'           => $value['name'],
                    'id_nationality' => $value['id_nationality'],
                    'birthday'       => NULL,
                    'type'           => TPrivatePassenger::TYPE_ADULT,
                    ];
                		TPrivatePassenger::addPrivatePassengers($adultData);
                }
                if (!empty($loadPassengersChildInfant[$cartValue->id_trip]['child'])) {
                    foreach ($loadPassengersChildInfant[$cartValue->id_trip]['child'] as $x => $valueChild) {
                        $childData = [
                        'id_booking'     => $savePrivateBooking,
                        'name'           => $valueChild['name'],
                        'id_nationality' => $valueChild['id_nationality'],
                        'birthday'       => $valueChild['birthday'],
                        'type'           => TPrivatePassenger::TYPE_CHILD,
                        ];
                		TPrivatePassenger::addPrivatePassengers($childData);    
               		}
                }
                
                if (!empty($loadPassengersChildInfant[$cartValue->id_trip]['infant'])) {
                    foreach ($loadPassengersChildInfant[$cartValue->id_trip]['infant'] as $x => $valueInfant) {
                         $infantData = [
                         'id_booking'     => $savePrivateBooking,
                         'name'           => $valueInfant['name'],
                         'id_nationality' => $valueInfant['id_nationality'],
                         'birthday'       => $valueInfant['birthday'],
                         'type'           => TPrivatePassenger::TYPE_INFANT,
                         ];
                		TPrivatePassenger::addPrivatePassengers($infantData);       
                    }
                }

                

            $payment[]     = $dataPrivateBooking['amount'];
            $payment_idr[] = $dataPrivateBooking['amount_idr'];
            $cartValue->delete();
            
         }
            $modelPayment->total_payment     = array_sum($payment);
            $modelPayment->total_payment_idr = array_sum($payment_idr);
            $modelPayment->save(false);
            $session                         = session_unset();
            $session                         = Yii::$app->session;
            $session->open();
            $session['cust_id']              = $modelPayment->id;
            $session['token']                = $modelPayment->token;
            $session['timeout']              = date('Y-m-d H:i:s', strtotime('+2 HOURS'));
            $session['payment-message']		 = "Payment Private Transfers Gilitransfers From : ";
            $session->close();

            $transaction->commit();
            return $this->redirect(['/payment']);
       } catch(\Exception $e) {
           $transaction->rollBack();
           throw $e;
       }

       

    }else{

    	return $this->render('private-detail',[
				'cartList'           => $cartList,
				'modelPayment'       => $modelPayment,
				'modelAdults'        => (empty($modelAdults)) ? [[new TPassenger]] : $modelAdults,
				'helperAdult'        => $helperAdult,
				'listNationality'    => $listNationality,
				'modelChildsInfants' => $modelChildsInfants,

                ]);
	}
	}

	// public function actionRenderExtraForm(){
	// 	//if (Yii::$app->request->isAjax) {
	// 		$model
	// 	// }else{
	// 	// 	$session = Yii::$app->session;
	// 	// 	$session         = session_unset();
	// 	// 	return $this-goHome();
	// 	// }
	// }

	
}