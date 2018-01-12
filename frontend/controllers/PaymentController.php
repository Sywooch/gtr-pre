<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use common\models\TPayment;
use common\models\TPaymentMethod;
use common\models\TBooking;
use common\models\TPaypalTransaction;
use common\models\TPaypalPayer;
use common\models\TPaypalIntent;
use common\models\TPaypalStatus;
use common\models\TWebhook;
use common\models\TWebhookEvent;
use common\models\TPaypalPayerStatus;
use common\models\TConfirmPayment;
use common\models\TBankTransferTransaction;
use frontend\models\PaymentModel;
use yii\web\NotFoundHttpException;
use yii\helpers\Json;
use yii\web\UploadedFile;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
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

    protected function findPayment($token){
        if (($payment = TPayment::findOne(['token'=>$token])) !== null) {
            return $payment;
        }else{
            throw new NotFoundHttpException('Data Not Found, Please Contact Us');
        }
    }

    public function actionIndex(){
		$session      = Yii::$app->session;
		$modelPayment = $this->findPayment($session['token']);
		$listPaymentMethod = ArrayHelper::map(TPaymentMethod::find()->where(['!=','id',0])->asArray()->all(),'id', 'method');

        if ($modelPayment->load(Yii::$app->request->post()) && $modelPayment->validate()) {
           $transaction = Yii::$app->db->beginTransaction();
	    	try {
	    		$modelPayment->save(false);
				$result             = TPayment::getVirtualAccount($session['token']);
				$resultArray        = Json::decode($result, $asArray = true);
				$saveResult         = TBankTransferTransaction::addData($resultArray, $modelPayment->id_payment_method);
				$transaction->commit();
				$session            = session_unset();
				$session            =Yii::$app->session;
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
				'modelPayment'      =>$modelPayment,
				'listPaymentMethod' =>$listPaymentMethod,
                ]);
       }

    }

    public function actionRenderPaypalButton(){
         $session       = Yii::$app->session;
         $modelpembayaranPaypal = TPayment::find()->where(['token'=>$session['token']])->asArray()->one();

         $message = $session['payment-message'];
         return $this->renderAjax('paypal',[
         'modelpembayaranPaypal'=>$modelpembayaranPaypal,
         'message' => $message,
         ]);    
    }

    public function actionRenderSubmitButton(){
    	if (Yii::$app->request->isAjax) {
    		$data = Yii::$app->request->post();
    		return '<center class="row">
    				<b class="payment-harga">IDR ' .number_format($data['payment_idr'],0).'</b>
  					</center>'.Html::submitButton('Confirm', ['id'=>'submit-payment-button','class' => 'btn btn-lg btn-warning btn-block']);
    	}else{
    		return $this->goHome();
    	}
    }

	public function actionConfirm($token = null){
		$this->layout = 'no-cart';
		if ($token != null && ($modelPayment = $this->findPaymentMaskToken($token)) !== null) {
			$modelConfirmPayment = new TConfirmPayment();
			$modelConfirmPayment->id = $modelPayment->id;
			if ($modelConfirmPayment->load(Yii::$app->request->post())) {
				$transaction = Yii::$app->db->beginTransaction();
				try {
					$modelPayment         = $modelConfirmPayment->tPayment;
					$modelPayment->status = $modelPayment::STATUS_PENDING;
					$modelBooking         = $modelConfirmPayment->tPayment->tBookings;
					foreach ($modelBooking as $key => $valBooking) {
						$valBooking->id_status = $valBooking::STATUS_VALIDATION;
						$valBooking->save();
					}
					$modelConfirmPayment->imageFiles = UploadedFile::getInstance($modelConfirmPayment, 'imageFiles');
					$modelConfirmPayment->uploadProof();
					$modelPayment->save(false);
					$modelConfirmPayment->save(false);
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
					'modelConfirmPayment' => $modelConfirmPayment,
				]);

			}
		}else{
			return $this->goHome();
		}
	}

	protected function findPaymentMaskToken($maskToken){
		$tokenval = Yii::$app->getSecurity()->unmaskToken($maskToken);
        return TPayment::find()->where(['token'=>$tokenval])->andWhere(['status'=>1])->one();
	}

    public function actionSuccess(){
    	$session                = Yii::$app->session;
	    if (Yii::$app->request->isAjax) {
				$data                   = Yii::$app->request->post();
				$transaction            = Yii::$app->db->beginTransaction();
				try {
				$modelPaypalTransaction = TPaypalTransaction::addTransactionData($data['umk']);
				$transaction->commit();
				$session                = session_unset();
				$session                =Yii::$app->session;
				$session->open();
				$session['payment']     = 'sukses';
				return $this->redirect(['thank-you']);
			} catch(\Exception $e) {
			    $transaction->rollBack();
			    throw $e;
			}
			
	    }else{
	    	$session                = session_unset();
	    	return $this->goHome();
	    }
	}

	public function actionPending(){
			$session = Yii::$app->session;
			if (Yii::$app->request->isAjax) {
				$session = Yii::$app->session;
				$modelPayment = $this->findPayment($session['token']);
				// $modelBooking = $modelPayment->tBookings;
				$transaction = Yii::$app->db->beginTransaction();
				try {
					$modelPayment->setPaymentBookingStatus($modelPayment::STATUS_PENDING,$modelPayment::STATUS_UNCONFIRMED);
				    $modelPayment->id_payment_method = $modelPayment::STATUS_UNCONFIRMED; //Payament Method PAYPAL
				    $modelPayment->save();
				    $transaction->commit();
				    return $this->redirect(['error']);
				} catch(\Exception $e) {
				    $transaction->rollBack();
				    throw $e;
				}
				
			}else{
			$session = session_unset();
    		 return $this->goHome();
			}
            

    }

    public function actionThankYou(){
        $session = Yii::$app->session;
        if ($session['payment'] == 'sukses') {
        	$modelPayment = TPayment::getArrayPaymentByToken($session['token']);
        	// if($modelPayment['id_payment_method'] == 1){
        	// 	return $this->render('thank-you-paypal',['modelPayment'=>$modelPayment]);
        	// }else
        	// if ($modelPayment['id_payment_method'] == 2) {
        	// 	return $this->render('thank-you-bca',['modelPayment'=>$modelPayment]);
        	// }else{
        		return $this->render('thank-you',['modelPayment'=>$modelPayment]);
        	//}
            
        }else{
            return $this->goHome();
        }
        
    }

    public function actionError(){
    	$session = Yii::$app->session;
		if (Yii::$app->request->isAjax) {
				$session['payment'] = 'error';
	    		$this->redirect(['payment-error']);
	    	}else{
		   		$session = session_unset();
	    		return $this->goHome();
	   	}
    }

    public function actionPaymentError(){
    	$session = Yii::$app->session;
    	if ($session['payment'] == 'error') {
	    	return $this->render('error');
	    }else{
	    	$session = session_unset();
	    	return $this->goHome();
	    }
	   	
    }

	public function actionWebHook(){
		if (Yii::$app->request->isPost) {
				$WebHookJson  = file_get_contents('php://input');
				$WebHookArray = Json::decode($WebHookJson, $asArray = true);
				$transaction  = Yii::$app->db->beginTransaction();
				try {
				    $modelWebHook = TWebhook::addWebHook($WebHookArray);
				    $transaction->commit();
				    return "Succesfull";
				} catch(\Exception $e) {
				    $transaction->rollBack();
				    throw $e;
				}
				
		}else{
			return $this->goHome();
		}

	}

	public function actionNotificationMidtrans(){
		if (Yii::$app->request->isPost) {
			$inputJson = file_get_contents('php://input');
			// $inputJson = '{
			// 			    "va_numbers": [
			// 			        {
			// 			            "bank": "bca",
			// 			            "va_number": "118423077812"
			// 			        }
			// 			    ],
			// 			    "payment_amounts": [],
			// 			    "transaction_time": "2018-01-06 23:35:45",
			// 			    "gross_amount": "330000.00",
			// 			    "order_id": "GDKWGVWOJZ535H9O0EHM1PZVE",
			// 			    "payment_type": "bank_transfer",
			// 			    "signature_key": "2dc0f14cdd2d16fd6347043add9e23c8c755ea5d553d2eb4c908a02e2148a16f1b14325f33fb32c4ed10890fc5da8eeeb52459cac90a41db57b9d0c9f588c3bb",
			// 			    "status_code": "407",
			// 			    "transaction_id": "65d8e9c4-3061-49ab-9e69-e74f969c2f4b",
			// 			    "transaction_status": "expire",
			// 			    "fraud_status": "accept",
			// 			    "status_message": "Success, transaction is found"
			// 			}';
			$inputArray     = Json::decode($inputJson, $asArray = true);
			$orderId        = $inputArray['order_id'];
			$statusCode     = $inputArray['status_code'];
			$grossAmount    = $inputArray['gross_amount'];
			$serverKey      = Yii::$app->params['MidtransServerKey'];
			$input          = $orderId.$statusCode.$grossAmount.$serverKey;
			$signatureLocal = openssl_digest($input, 'sha512');
			if ($inputArray['signature_key'] == $signatureLocal) {
				$transaction = Yii::$app->db->beginTransaction();
				try {
				    $data = [
					'transaction_id'     => $inputArray['transaction_id'],
					'transaction_status' => $inputArray['transaction_status'],
					];
					TBankTransferTransaction::updateData($data);
					$transaction->commit();
					return Yii::$app->response->statusCode = 200;
				    
				} catch(\Exception $e) {
				    $transaction->rollBack();
				    throw $e;
				}
				
			}else{
				return Yii::$app->response->statusCode = 200;
			}
		}else{
			return $this->goHome();
		}
	}



	public function actionHasilWebHook(){
		return $this->render('web-hook',['hasil'=>"ok"]);
	}
	
}