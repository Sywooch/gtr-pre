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


	public function actionWebHook(){
		if (Yii::$app->request->isPost) {
			/*$request =Yii::$app->request;
			$nama = $request->post('nama','unamed');
			$alamat = $request->post('alamat','unadreess');
			$array = ['nama'=>$nama,'Alamat'=>$alamat];
			$textjson = Json::encode($array);*/
			try {
				$textjson = file_get_contents('php://input');
			$jsonfile =  Yii::getAlias('@frontend/E-Ticket/web-hook.json');
			$fp = fopen($jsonfile, 'w+');
			fwrite($fp, $textjson);
			fclose($fp);
				return true;
			} catch (Exception $e) {
				return false;
			}
			
			//return $this->redirect(['hasil-web-hook','hasil'=>$array]);
		}else{
			return $this->render('form-web-hook');
		}

	}

	public function actionHasilWebHook(array $hasil){
		return $this->render('web-hook',['hasil'=>"ok"]);
	}
}