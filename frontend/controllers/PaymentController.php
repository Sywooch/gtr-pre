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
use common\models\TPaypalPayerStatus;
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
			//$data                                = Yii::$app->request->post();
			$json = '{
	"id":"PAY-1CN193682K5796124LIIVPEA",
	"intent":"sale",
	"state":"approved",
	"cart":"3M3194058P4398129",
	"create_time":"2017-11-19T10:06:22Z",
"payer":{
		"payment_method":"paypal",
		"status":"VERIFIED",
		"payer_info":{
			"email":"mastuyink94-buyer@gmail.com",
			"first_name":"test",
			"middle_name":"test",
			"last_name":"buyer",
			"payer_id":"J6HNCKBADB4MG",
			"country_code":"US",
			"shipping_address":{
				"recipient_name":"test buyer",
				"line1":"1 Main St",
				"city":"San Jose",
				"state":"CA",
				"postal_code":"95131",
				"country_code":"US"
			}
		}
	},
"transactions":[{
	"amount":{
		"total":"70.00",
		"currency":"USD"
	},
	"item_list":{
		"items":[{
			"name":"Payment Gilitranfers From : sayyidina/aziest99@gmail.com",
			"price":"70.00",
			"currency":"USD",
			"quantity":"1",
			"description":"1 Trip"
		}]
	},
	"related_resources":[{
		"sale":{
			"id":"8G122845J1386645F",
			"state":"completed",
			"payment_mode":"INSTANT_TRANSFER",
			"protection_eligibility":"ELIGIBLE",
			"parent_payment":"PAY-1CN193682K5796124LIIVPEA",
			"create_time":"2017-11-19T10:06:21Z",
			"update_time":"2017-11-19T10:06:21Z",
			"amount":{
				"total":"70.00",
				"currency":"USD",
				"details":{
					"subtotal":"70.00"
				}
			}
		}
	}]
}]
}';
			$data['umk'] = Json::decode($json, $asArray = true);
			$transaction = Yii::$app->db->beginTransaction();
			try {
				$PayerId                             = $this->checkPayer($data['umk']['payer']);
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
		if (($modelPayer = TPaypalPayer::findOne($arrayPayer['payer_info']['payer_id'])) !== null ) {
			return $modelPayer->id;
		}else{
				$modelPayer             = new TPaypalPayer();
				$modelPayer->id         = $arrayPayer['payer_info']['payer_id'];
				$modelPayer->full_name  = $arrayPayer['payer_info']['first_name']." ".$arrayPayer['payer_info']['middle_name']." ".$arrayPayer['payer_info']['last_name'];
				$modelPayer->email      = $arrayPayer['payer_info']['email'];
				$modelPayer->address    = "Street : ".$arrayPayer['payer_info']['shipping_address']['line1']." | City: ".$arrayPayer['payer_info']['shipping_address']['city']." | State : ".$arrayPayer['payer_info']['shipping_address']['state']." | Post Code : ".$arrayPayer['payer_info']['shipping_address']['postal_code'];
				$modelPayer->id_country = $arrayPayer['payer_info']['country_code'];
				if (($modelPayerStatus = TPaypalPayerStatus::find()->where(['status'=>$arrayPayer['payer_info']['status']])->asArray()->one()) !== null) {
					$modelPayer->id_status = $modelPayerStatus['id'];
				}else{
					$newPayerStatus = new TPaypalPayerStatus();
					$newPayerStatus->status = $arrayPayer['payer_info']['status'];
					$newPayerStatus->save();
					$modelPayer->id_status = $newPayerStatus->id;
				}
				$modelPayer->save(false);
			    $transaction->commit();
			    return $modelPayer->id;
			
		}
	}

	public function actionError(){
            return $this->render('error');

    }

    public function actionCurlTest(){
    	/*$response = curl -v -X GET https://api.sandbox.paypal.com/v1/payments/payment/PAY-0US81985GW1191216KOY7OXA \
-H "Content-Type:application/json" \
-H "Authorization: Bearer Access-Token" \
-d '{}'

	$uri = 'https://api.sandbox.paypal.com/v1/payments/payment/PAY-0US81985GW1191216KOY7OXA';
$ch = curl_init($uri);
curl_setopt_array($ch, array(
    CURLOPT_HTTPHEADER  => array('Authorization: 123456'),
    CURLOPT_RETURNTRANSFER  =>true,
    CURLOPT_VERBOSE     => 1
));
$out = curl_exec($ch);
curl_close($ch);
// echo response output
echo $out;*/
    }


	public function actionWebHook(){
		if (Yii::$app->request->isPost) {
				$WebHookJson = file_get_contents('php://input');
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
					$modelWebHook->id_parent_payment     = $WebHookArray['resource']['parent_payment'];
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