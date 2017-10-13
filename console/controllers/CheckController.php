<?php
namespace console\controllers;


use yii\console\Controller;
use Yii;
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
}