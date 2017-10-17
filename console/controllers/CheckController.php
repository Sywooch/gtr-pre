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
        Yii::$app->runAction('mailer/paypal');
    }

    public function actionInvoice(){
        Yii::$app->controllerNamespace = "backend\controllers";
        Yii::$app->runAction('mailer/invoice');
        
    }

    public function actionPaymentTimeout(){
    	if (($modelPayment = TPayment::find()->where(['status'=>1])->andWhere(['<','exp',date('Y-m-d H:i:s')])->orderBy(['exp'=>SORT_DESC])->one()) !== null) {
    		$modelBooking = TBooking::find()->where(['id_payment'=>$modelPayment->id])->all();
    		$transaction = Yii::$app->db->beginTransaction();
    		try {
    		    foreach ($modelBooking as $key => $value) {
    		    	$affectedStock = count(TPassenger::find()->where(['id_booking'=>$value->id])->andWhere(['!=','id_type',3])->all());
    		    	$modelTrip = TTrip::findOne($value->id_trip);
    		    	$modelTrip->stock = $modelTrip->stock+$affectedStock;
    		    	$modelTrip->save();
    		    	$value->delete();
    		    }
    		    $modelPayment->delete();
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