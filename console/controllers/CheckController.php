<?php
namespace console\controllers;


use yii\console\Controller;
use Yii;
use common\models\TPayment;
use common\models\TBooking;
use common\models\TTrip;
use common\models\TPassenger;
Class CheckController extends Controller
{
    public function actionMailer(){
        Yii::$app->controllerNamespace = "backend\controllers";
        Yii::$app->runAction('mailer/ticketing');
    }

    public function actionInvoice(){
        Yii::$app->controllerNamespace = "backend\controllers";
        Yii::$app->runAction('mailer/invoice');
        
    }

    public function actionPaymentTimeout(){
    	if (($modelPayment = TPayment::find()->where(['status'=>1])->andWhere(['<','exp',date('Y-m-d H:i:s')])->orderBy(['exp'=>SORT_DESC])->one()) !== null) {
    		$transaction = Yii::$app->db->beginTransaction();
    		try {
    		    $modelPayment->setPaymentBookingStatus($modelPayment::STATUS_EXPIRED,$modelPayment::STATUS_EXPIRED);
                $modelPayment->save(false);
    		    $transaction->commit();
    		} catch(\Exception $e) {
    		    $transaction->rollBack();
    		    throw $e;
    		}
    	}else{
    		return true;
    	}
    	
    }
}