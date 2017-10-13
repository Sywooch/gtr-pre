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
/**
 * Content controller
 */
class PaymentController extends Controller
{
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
}