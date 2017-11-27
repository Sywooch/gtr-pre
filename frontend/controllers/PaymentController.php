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
use common\models\TBooking;
use common\models\TPaypalTransaction;
use common\models\TPaypalPayer;
use common\models\TPaypalIntent;
use common\models\TPaypalStatus;
use common\models\TWebhook;
use common\models\TWebhookEvent;
use common\models\TPaypalPayerStatus;
use common\models\TConfirmPayment;
use yii\web\NotFoundHttpException;
use yii\helpers\Json;
use yii\web\UploadedFile;
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
				$session                = Yii::$app->session;
				$session->open();
				$session['payment']     = 'sukses';
				return $this->redirect(['/book/thank-you']);
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
				$modelPayment = $this->findPaymentByToken($session['token']);
				$modelBooking = $modelPayment->tBookings;
				$transaction = Yii::$app->db->beginTransaction();
				try {
				    $modelPayment->status = $modelPayment::STATUS_PENDING;
				    $modelPayment->id_payment_method = $modelPayment::STATUS_UNCONFIRMED; //PAYPAL
				    foreach ($modelBooking as $key => $valBooking) {
						$valBooking->id_status = $valBooking::STATUS_VALIDATION;
						$valBooking->save();
				    }
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

    public function actionError(){
    	$session = Yii::$app->session;
    	if (isset($session['token'])) {
    		$session = session_unset();
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

	public function actionHasilWebHook(){
		return $this->render('web-hook',['hasil'=>"ok"]);
	}

	protected function findPaymentByToken($token){
		if (($modelPayment = TPayment::find()->where(['token'=>$token])->one()) !== null) {
			return $modelPayment;
		}else{
			 throw new NotFoundHttpException('The requested Cannot Be Process.');
			
		}
	}
}