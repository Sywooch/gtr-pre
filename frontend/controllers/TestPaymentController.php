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
class TestPaymentController extends Controller
{

    public function actionSuccess(){
	    if (Yii::$app->request->isGet) {
			$json = '{"id":"PAY-29014757D3344382YLIK2IOQ","intent":"sale","state":"approved","cart":"1C4115243A295460W","payer":{"payment_method":"paypal","status":"VERIFIED","payer_info":{"email":"mastuyink94-buyer@gmail.com","first_name":"test","last_name":"buyer","payer_id":"J6HNCKBADB4MG","shipping_address":{"recipient_name":"test buyer","line1":"1 Main St","city":"San Jose","state":"CA","postal_code":"95131","country_code":"US"},"phone":"4088479718","country_code":"US"}},"transactions":[{"amount":{"total":"39.00","currency":"USD","details":{"subtotal":"39.00"}},"payee":{"merchant_id":"8LQED7PJJ2XZG"},"description":"Payment Gilitranfers From : istanamedia | aziest99@gmail.com | 2 Trip","item_list":{"items":[{"name":"Payment Gilitranfers From : istanamedia | aziest99@gmail.com | 2 Trip","description":"GJ0XBFI36ZVQBDG7USX37VNU3","price":"39.00","currency":"USD","tax":"0.00","quantity":1}],"shipping_address":{"recipient_name":"test buyer","line1":"1 Main St","city":"San Jose","state":"CA","postal_code":"95131","country_code":"US"}},"related_resources":[{"sale":{"id":"6LB16453D4644480T","state":"completed","amount":{"total":"39.00","currency":"USD","details":{"subtotal":"39.00"}},"payment_mode":"INSTANT_TRANSFER","protection_eligibility":"ELIGIBLE","protection_eligibility_type":"ITEM_NOT_RECEIVED_ELIGIBLE,UNAUTHORIZED_PAYMENT_ELIGIBLE","transaction_fee":{"value":"0.65","currency":"USD"},"parent_payment":"PAY-29014757D3344382YLIK2IOQ","create_time":"2017-11-21T07:39:35Z","update_time":"2017-11-21T07:39:35Z","links":[{"href":"https://api.sandbox.paypal.com/v1/payments/sale/6LB16453D4644480T","rel":"self","method":"GET"},{"href":"https://api.sandbox.paypal.com/v1/payments/sale/6LB16453D4644480T/refund","rel":"refund","method":"POST"},{"href":"https://api.sandbox.paypal.com/v1/payments/payment/PAY-29014757D3344382YLIK2IOQ","rel":"parent_payment","method":"GET"}]}}]}],"create_time":"2017-11-21T07:39:35Z","links":[{"href":"https://api.sandbox.paypal.com/v1/payments/payment/PAY-29014757D3344382YLIK2IOQ","rel":"self","method":"GET"}]}';
			$data['umk'] = Json::decode($json, $asArray = true);
			$transaction = Yii::$app->db->beginTransaction();
			try {
				$modelPaypalTransaction = TPaypalTransaction::addTransactionData($data['umk']);
				return $this->redirect(['/book/payment']);
			} catch(\Exception $e) {
			    $transaction->rollBack();
			    throw $e;
			}
			
	    }else{
	    	return $this->goHome();
	    }
	}

	public function actionError(){
            return $this->render('error');

    }

    public function actionCurlTest(){
//for get apis token

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.sandbox.paypal.com/v1/oauth2/token",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "grant_type=client_credentials",
  CURLOPT_HTTPHEADER => array(
    "authorization: Basic QVpvOHhfdmJoMHlFcXdiUmY2Yl9Ka1ZtQUFfRFBrTXdxOXVzNHl1V3NYMXVyclVtT2NDY3d1OU41dlh3azFtdXFrdktJVEJNcWpVOXdWUUs6RUhzekNYTnZUS3JPODllUVZYQ2tSWTBSOHN3S1hUNlhvS1hoTEctNDU1MlpFVDNFRW4xMjZvNi1qeWR5V3ZWYlRiaWY5ckQzc0tZdDM5VEI=",
    "cache-control: no-cache",
    "content-type: application/x-www-form-urlencoded",
    "postman-token: 1085c749-65d8-05c2-7c07-8ab1ef103219"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.sandbox.paypal.com/v1/payments/payment/PAY-29014757D3344382YLIK2IOQ",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "authorization: Bearer A21AAHKjLvjo538sHFx_dlsU6UKMioKg6_U4lKYy6fDSOj3InVydviuAyUv0UibhJuUmZmXpdVo6NOet5xxlTtMFBurRK3w3w",
    "cache-control: no-cache",
    "content-type: application/json",
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
//for get transaction detail from APis
	/*$uri = 'https://api.sandbox.paypal.com/v1/payments/payment/PAY-1GE17811VW969403LLIJOBLQ';
$ch = curl_init($uri);
curl_setopt_array($ch, [
    CURLOPT_HTTPHEADER  => ['Content-Type:application/json','Authorization: Bearer A21AAGEH9c5qhyT8cW5dbKZ8QJl8UvhN9QdNEObrgOtkc4eaY5IYhImaLHCHz2Fj9kvovaUgyaYsss1MYms4HC6VVFZGiwDFw'],
    CURLOPT_RETURNTRANSFER  =>true,
    CURLOPT_VERBOSE     => 1
]);
$out = curl_exec($ch);
curl_close($ch);
// echo response output
var_dump(Json::decode($out, $asArray = true));*/
    }


	public function actionWebHook(){
$WebHookJson = '{
  "id": "WH-09885192MJ296760T-08T0947816330130S",
  "create_time": "2017-11-27T15:08:03.521Z",
  "resource_type": "sale",
  "event_type": "PAYMENT.SALE.COMPLETED",
  "summary": "Payment completed for $ 8.0 USD",
  "resource": {
    "amount": {
      "total": "8.00",
      "currency": "USD",
      "details": {
        "subtotal": "8.00"
      }
    },
    "id": "32R651384L280424A",
    "parent_payment": "PAY-3T553269UA971631FLIOCSQA",
    "update_time": "2017-11-27T15:07:32Z",
    "create_time": "2017-11-27T15:07:32Z",
    "payment_mode": "INSTANT_TRANSFER",
    "state": "completed",
    "links": [
      {
        "href": "https://api.sandbox.paypal.com/v1/payments/sale/32R651384L280424A",
        "rel": "self",
        "method": "GET"
      },
      {
        "href": "https://api.sandbox.paypal.com/v1/payments/sale/32R651384L280424A/refund",
        "rel": "refund",
        "method": "POST"
      },
      {
        "href": "https://api.sandbox.paypal.com/v1/payments/payment/PAY-3T553269UA971631FLIOCSQA",
        "rel": "parent_payment",
        "method": "GET"
      }
    ],
    "invoice_number": "",
    "protection_eligibility_type": "ITEM_NOT_RECEIVED_ELIGIBLE,UNAUTHORIZED_PAYMENT_ELIGIBLE",
    "transaction_fee": {
      "value": "0.53",
      "currency": "USD"
    },
    "protection_eligibility": "ELIGIBLE"
  },
  "status": "PENDING",
  "transmissions": [
    {
      "webhook_url": "https://gilitransfers.com/payment/web-hook",
      "transmission_id": "c441a630-d384-11e7-a115-77339302725b",
      "status": "PENDING",
      "timestamp": "2017-11-27T15:08:03Z"
    }
  ],
  "links": [
    {
      "href": "https://api.sandbox.paypal.com/v1/notifications/webhooks-events/WH-09885192MJ296760T-08T0947816330130S",
      "rel": "self",
      "method": "GET",
      "encType": "application/json"
    },
    {
      "href": "https://api.sandbox.paypal.com/v1/notifications/webhooks-events/WH-09885192MJ296760T-08T0947816330130S/resend",
      "rel": "resend",
      "method": "POST",
      "encType": "application/json"
    }
  ],
  "event_version": "1.0"
}';
				$WebHookArray = Json::decode($WebHookJson, $asArray = true);
				$transaction = Yii::$app->db->beginTransaction();
				try {
				    $modelWebHook = TWebhook::addWebHook($WebHookArray);
				    $transaction->commit();
				    return "Oke";
				} catch(\Exception $e) {
				    $transaction->rollBack();
				    throw $e;
				}
					
				    
				

	}

	public function actionHasilWebHook(){
		return $this->render('/payment/web-hook',['hasil'=>"ok"]);
	}
}