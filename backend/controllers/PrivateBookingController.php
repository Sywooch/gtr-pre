<?php

namespace backend\controllers;

use Yii;
use common\models\TPrivateBooking;
use backend\models\TPrivateBookingSearch;
use backend\models\TPaymentLog;
use backend\models\TPrivateOperator;
use backend\models\TPrivateBookingLog;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PrivateBookingController implements the CRUD actions for TPrivateBooking model.
 */
class PrivateBookingController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TPrivateBooking models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TPrivateBookingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDetailModal($id_booking){
        $modelBooking = $this->findModel($id_booking);
        return $this->renderAjax('_modal-detail-booking',['modelBooking'=>$modelBooking]);
    }

    /**
     * Displays a single TPrivateBooking model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TPrivateBooking model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TPrivateBooking();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TPrivateBooking model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TPrivateBooking model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TPrivateBooking model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TPrivateBooking the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TPrivateBooking::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionConfirmPayment(){
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $modelLogPayment = TPaymentLog::addPaymmentLog($data['idp'],TPaymentLog::EVENT_READ_CHECK);
                $transaction->commit();
            } catch(\Exception $e) {
                $transaction->rollBack();
            }
            
        }
    }

    public function actionCheckLogPayment($id_payment){
        if(($modelLogPayment = TPaymentLog::find()->joinWith(['idUser','idEvent','idPayment'])->where(['id_payment'=>$id_payment,'t_payment.id_payment_type'=>2])->asArray()->all()) != null){
            $btn = '<a data-toggle="popover" data-trigger="hover focus" data-popover-content="#log-'.$id_payment.'" data-placement="right" class="btn btn-xs btn-success fa fa-check-square-o"></a>';
            return $btn.'<div id="log-'.$id_payment.'" class="hidden panel panel-primary">'.$this->renderPartial('/booking/_log',['modelLog'=>$modelLogPayment]).'</div>';
           
        }else{
            return "<a data-toggle='tooltip' title='Mark As Confirm' class='confirm-btn btn material-btn material-btn_xs fa fa-check-square-o' value='".$id_payment."'></a>";
        }
    }

    public function actionCheckLogBooking($id_booking){
        if(($modelLogBooking = TPrivateBookingLog::find()->joinWith(['idUser','idEvent','idBooking'])->where(['id_booking'=>$id_booking])->asArray()->all()) != null){
            $btn = '<a data-toggle="popover" data-trigger="hover focus" data-popover-content="#log-booking-'.$id_booking.'" data-placement="right" class="btn-default btn-xs glyphicon glyphicon-time"></a>';
            return $btn.'<div id="log-booking-'.$id_booking.'" class="hidden panel panel-primary">'.$this->renderPartial('/booking/_log',['modelLog'=>$modelLogBooking]).'</div>';
           
        }else{
            return null;
        }
    }

    public function actionChangeOperator(){

        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $listOperator = TPrivateOperator::geAvailableOperator(true);
            return $this->renderPartial('_list-operator.php',[
                    'listOperator'=>$listOperator,
                    'id_booking' => $data['id_booking'],
                    ]);
        }elseif (Yii::$app->request->isPost) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $dataPost = Yii::$app->request->post();
                $modelPrivateBooking = $this->findModel($dataPost['id_booking']);
                $Operator = $this->getOneOperator($dataPost['id_operator']);
                    if (!isset($modelPrivateBooking->idOperator)) {
                        $note = '<b class="text-info">New Operator </b><br> '.$Operator['name'].' | '.$Operator['phone'].' | '.$Operator['email']; 
                    }else{
                        $note = '<b class="text-danger">Change operator</b> <br>'.$modelPrivateBooking->idOperator->name.' | '.$modelPrivateBooking->idOperator->phone.' | '.$modelPrivateBooking->idOperator->email.'<br> = TO = <br>'.$Operator['name'].' | '.$Operator['phone'].' | '.$Operator['email']; 
                    
                    }
                $modelPrivateBooking->id_operator = $dataPost['id_operator'];
                if($modelPrivateBooking->validate()){
                    $modelPrivateBooking->save(false);

                    TPrivateBookingLog::addLog($modelPrivateBooking->id,TPrivateBookingLog::EVENT_MODIFY,$note);
                    $transaction->commit();
                    return $this->redirect(['index']);
                }else{
                    $transaction->rollBack();
                    return "Something Its Wrong";
                }
                
            } catch(\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }

        }else{
            return $this->goHome();
        }
    }

    public function actionSendCustomerInfo(){
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $modelPrivateBooking = $this->findModel($data['id_booking']);
            if (isset($modelPrivateBooking->idOperator)) {
                try {
                    $sendTicket = Yii::$app->mailReservation->compose()
                    ->setFrom(Yii::$app->params['reservationEmail'])
                    ->setTo($modelPrivateBooking->idPayment->email)
                    ->setSubject('Private Transfers Information')
                    ->setHtmlBody($this->renderAjax('/email-ticket/private-transfers-email-info',[
                        'modelPrivateBooking'=>$modelPrivateBooking,
                        ]))->send();
                    $note = '<b class="text-success">Send Operator Contact To Customer</b>';
                    TPrivateBookingLog::addLog($modelPrivateBooking->id,TPrivateBookingLog::EVENT_RES_TICK,$note);
                    return "Sending Email Successsfull";
                } catch (\Exception $e) {
                    return "Sending Email Failed";
                }
            }else{
                return "Process Request Failed <br> Please Assignment Operator First";
            }
            
        }
    }

    public function actionSendCustomerInfoPayment(){
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $modelPrivateBooking = TPrivateBooking::find()->where(['id_payment'=>$data['id_payment']])->all();
                try {
                    $sendTicket = Yii::$app->mailReservation->compose()
                    ->setFrom(Yii::$app->params['reservationEmail'])
                    ->setTo($modelPrivateBooking[0]->idPayment->email)
                    ->setSubject('Private Transfers Information')
                    ->setHtmlBody($this->renderAjax('/email-ticket/private-transfers-email-info-payment',[
                        'modelPrivateBooking'=>$modelPrivateBooking,
                        ]))->send();
                    $note = '<b class="text-success">Send Operator Contact To Customer</b>';
                    foreach ($modelPrivateBooking as $value) {
                        TPrivateBookingLog::addLog($value->id,TPrivateBookingLog::EVENT_RES_TICK,$note);
                    }
                    
                    return "Sending Email Successsfull";
                } catch (\Exception $e) {
                    throw $e;
                    return "Sending Email Failed";
                }
            
        }
    }

    public function actionSendEmailOperator(){
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $modelPrivateBooking = $this->findModel($data['id_booking']);
            if (isset($modelPrivateBooking->idOperator)) {
                if ($data['type'] == 1) {
                    $type = 'Operator Reservation';
                }elseif($data['type'] == 2){
                    $type = 'Operator Cancellation';
                }else{
                    return "Something Its Wrong <br>  Please Try Again";
                }
                try {
                    $sendTicket = Yii::$app->mailReservation->compose()
                    ->setFrom(Yii::$app->params['reservationEmail'])
                    ->setTo($modelPrivateBooking->idOperator->email)
                    ->setSubject($type.' Private Transfers Gilitransfers')
                    ->setHtmlBody($this->renderAjax('/email-ticket/private-transfers-email-operator',[
                        'modelPrivateBooking'=>$modelPrivateBooking,
                        'type' =>$type,
                        ]))->send();
                    $note = '<b>Send '.$type.'</b>';
                    TPrivateBookingLog::addLog($modelPrivateBooking->id,TPrivateBookingLog::EVENT_RES_RESV,$note);
                    return "Sending Email Successsfull";
                } catch (\Exception $e) {
                    return "Sending Email Failed <br> Please Try Again";
                }
            }else{
                return "Process Request Failed <br> Please Assignment Operator First";
            }
        }else{
            return $this->goHome();
        }
    }

    protected function getOneOperator($id){
        return TPrivateOperator::find()->where(['id'=>$id])->asArray()->one();
    }

}
