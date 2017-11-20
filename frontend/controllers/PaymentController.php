<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use frontend\models\TConfirmPayment;
use common\models\TBooking;
use common\models\TPaypalTransaction;
use common\models\TPaypalPayer;
use common\models\TPaypalIntent;
use common\models\TPaypalStatus;
use common\models\TWebhook;
use common\models\TWebhookEvent;
use yii\web\NotFoundHttpException;
use yii\helpers\Json;
/**
 * Content controller
 */
class PaymentController extends Controller
{

    public function beforeAction($action)
    {    
        if ($action->id == 'web-hook' || $action->id == 'hasil-web-hook') {
		$this->enableCsrfValidation = false;
		}
		    return parent::beforeAction($action);  
    }

	public function actionConfirm($token = null){
		$this->layout = 'no-cart';
		if ($token != null && ($modelPayment = $this->findPaymentMaskToken($token)) !== null) {
			
			if ($modelPayment->load(Yii::$app->request->post()) && $modelPayment->validate()) {
				$transaction = Yii::$app->db->beginTransaction();
				try {
					$modelPayment->status = '2';
				    $modelPayment->save(false);
				    $transaction->commit();
				    $session = Yii::$app->session;
				    $session['timeout'] = 'confirm';
				    return $this->goHome();
				} catch(\Exception $e) {
				    $transaction->rollBack();
				    throw $e;
				}
			}else{

				return $this->render('payment', [
					'modelPayment' => $modelPayment,
				]);

			}
		}else{
			return $this->goHome();
		}
	}

	protected function findPaymentMaskToken($maskToken){
		$tokenval = Yii::$app->getSecurity()->unmaskToken($maskToken);
        if (($modelPayment = TConfirmPayment::find()->where(['token'=>$tokenval])->andWhere(['status'=>1])->one()) !== null) {
            return $modelPayment;
        }else{
            return null;
        }
	}

    public function actionSuccess(){
	    if (Yii::$app->request->isAjax) {
			$data                                = Yii::$app->request->post();
			$transaction = Yii::$app->db->beginTransaction();
			try {
				$PayerId                             = $this->checkPayer($data['umk']['payer']['payer_info']);
				$arrayTransaction                    = $data['umk']['transactions'][0]['related_resources'][0]['sale'];
				$modelPaypalTransaction              = new TPaypalTransaction();
				$modelPaypalTransaction->id          = $arrayTransaction['id'];
				$modelPaypalTransaction->id_payer    = $PayerId;
				$modelPaypalTransaction->amount      = $arrayTransaction['amount']['total'];
				$modelPaypalTransaction->currency    = $arrayTransaction['amount']['currency'];
				$modelPaypalTransaction->description = $data['umk']['transactions'][0]['item_list']['items'][0]['name'];
				$modelPaypalTransaction->id_intent   = $this->checkIntent($data['umk']['intent']);
				$modelPaypalTransaction->id_status   = $this->checkStatus($arrayTransaction['state']);
				$modelPaypalTransaction->paypal_time = $data['umk']['create_time'];
				$modelPaypalTransaction->datetime    = date('Y-m-d H:i:s');
				$modelPaypalTransaction->save(false);
				$transaction->commit();
				return $this->redirect(['/book/payment']);
			} catch(\Exception $e) {
			    $transaction->rollBack();
			    return $this->redirect(['/payment/error']);
			    throw $e;
			}
			
	    }
	}

	protected function checkStatus($status){
		if (($modelStatus = TPaypalStatus::find()->where(['status'=>$status])->asArray()->one()) !== null) {
			return $modelStatus['id'];
		}else{
			$modelStatus = new TPaypalStatus();
			$modelStatus->status = $status;
			$modelStatus->save(false);
			return $modelStatus->id;
		}
	}

	protected function checkIntent($intent){
		if (($modelIntent = TPaypalIntent::find()->where(['intent'=>$intent])->asArray()->one()) !== null) {
			return $modelIntent['id'];
		}else{
			$modelIntent = new TPaypalIntent();
			$modelIntent->intent = $intent;
			$modelIntent->save(false);
			return $modelIntent->id;
		}
	}

	protected function checkPayer(array $arrayPayer){
		if (($modelPayer = TPaypalPayer::findOne($arrayPayer['payer_id'])) !== null ) {
			return $modelPayer->id;
		}else{
				$modelPayer             = new TPaypalPayer();
				$modelPayer->id         = $arrayPayer['payer_id'];
				$modelPayer->full_name  = $arrayPayer['first_name']." ".$arrayPayer['middle_name']." ".$arrayPayer['last_name'];
				$modelPayer->email      = $arrayPayer['email'];
				$modelPayer->address    = "Street : ".$arrayPayer['shipping_address']['line1']." | City: ".$arrayPayer['shipping_address']['city']." | State : ".$arrayPayer['shipping_address']['state']." | Post Code : ".$arrayPayer['shipping_address']['postal_code'];
				$modelPayer->id_country = $arrayPayer['country_code'];
				$modelPayer->id_status  = "1";
				$modelPayer->save(false);
			    $transaction->commit();
			    return $modelPayer->id;
			
		}
	}

	public function actionError(){
            return $this->render('error');

    }


	public function actionWebHook(){
		if (Yii::$app->request->isPost) {
				$WebHookJson = file_get_contents('php://input');
				/*$WebHookJson = '{
						"id": "WH-2WR32451HC0233532-67976317FL4543714",
						"create_time": "2014-10-23T17:23:52Z",
						"resource_type": "sale",
						"event_type": "PAYMENT.SALE.COMPLETED",
						"summary": "A successful sale payment was made for $ 0.48 USD",
						"resource": {
							"amount": {
								"total": "0.48",
								"currency": "USD"
							},
							"id": "80021663DE681814L",
							"parent_payment": "PAY-1PA12106FU478450MKRETS4A",
							"update_time": "2014-10-23T17:23:04Z",
							"clearing_time": "2014-10-30T07:00:00Z",
							"state": "completed",
							"payment_mode": "ECHECK",
							"create_time": "2014-10-23T17:22:56Z",
							"links": [
								{
									"href": "https://api.paypal.com/v1/payments/sale/80021663DE681814L",
									"rel": "self",
									"method": "GET"
								},
								{
									"href": "https://api.paypal.com/v1/payments/sale/80021663DE681814L/refund",
									"rel": "refund",
									"method": "POST"
								},
								{
									"href": "https://api.paypal.com/v1/payments/payment/PAY-1PA12106FU478450MKRETS4A",
									"rel": "parent_payment",
									"method": "GET"
								}
							],
							"protection_eligibility_type": "ITEM_NOT_RECEIVED_ELIGIBLE,UNAUTHORIZED_PAYMENT_ELIGIBLE",
							"protection_eligibility": "ELIGIBLE"
						},
						"links": [
							{
								"href": "https://api.paypal.com/v1/notifications/webhooks-events/WH-2WR32451HC0233532-67976317FL4543714",
								"rel": "self",
								"method": "GET",
								"encType": "application/json"
							},
							{
								"href": "https://api.paypal.com/v1/notifications/webhooks-events/WH-2WR32451HC0233532-67976317FL4543714/resend",
								"rel": "resend",
								"method": "POST",
								"encType": "application/json"
							}
						],
						"event_version": "1.0"
					}';*/
				$WebHookArray = Json::decode($WebHookJson, $asArray = true);
				$transaction = Yii::$app->db->beginTransaction();
				try {
					$modelWebHook                        = new TWebhook();
					$modelWebHook->id                    = $WebHookArray['id'];
					$modelWebHook->id_resource_type      = $this->checkIntent($WebHookArray['resource_type']);
					$modelWebHook->id_event              = $this->checkEventType($WebHookArray['event_type']);
					$modelWebHook->id_status             = $this->checkStatus($WebHookArray['resource']['state']);
					$modelWebHook->description           = $WebHookArray['summary'];
					$modelWebHook->amount                = $WebHookArray['resource']['amount']['total'];
					$modelWebHook->currency              = $WebHookArray['resource']['amount']['currency'];
					$modelWebHook->id_paypal_transaction = $WebHookArray['resource']['id'];
					$modelWebHook->paypal_time           = $WebHookArray['create_time'];
					$modelWebHook->datetime              = date('Y-m-d H:i:s');
					$modelWebHook->validate();
					$modelWebHook->save(false);
				    $transaction->commit();
				    return true;
				} catch(\Exception $e) {
				    $transaction->rollBack();
				    return false;
				}
				
		}else{
			return $this->goHome();
		}

	}


	protected function checkEventType($Event){
		if (($modelEvent = TWebhookEvent::find()->where(['event'=>$Event])->asArray()->one()) !== null) {
			return $modelEvent['id'];
		}else{
			$modelEvent        = new TWebhookEvent();
			$modelEvent->event = $Event;
			$modelEvent->save(false);
			return $modelEvent->id;
		}

	}

	public function actionHasilWebHook(array $hasil){
		return $this->render('web-hook',['hasil'=>"ok"]);
	}
}