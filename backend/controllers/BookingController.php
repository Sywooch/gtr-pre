<?php

namespace backend\controllers;

use Yii;
use common\models\TBooking;
use app\models\TBookingSearch;
use app\models\BookingValidate;
use common\models\TPassenger;
use common\models\TRoute;
use common\models\THarbor;
use common\models\TMailQueue;
use common\models\TTrip;
use common\models\TCompany;
use common\models\TShuttleTime;
use common\models\TConfirmPayment;
use common\models\TPayment;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use mdm\admin\components\Helper;
use yii\helpers\ArrayHelper;
/**
 * BookingController implements the CRUD actions for TBooking model.
 */
class BookingController extends Controller
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

    public function actionCekNotif(){
        
    }

    public function actionPaymentSlip($id){
        $modelSlip = TConfirmPayment::find()->where(['id'=>$id])->asArray()->one();
        $response = Yii::$app->getResponse();
        return $response->sendFile($modelSlip['proof_payment'],'slip.jpg', [
                //'mimeType' => 'image/jpg',
               //'fileSize' => '386',
                'inline' => true
        ]);
    }

    public function actionShuttleTime(){
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            if (($modelShuttleTime = TShuttleTime::find()->where(['id_company'=>$data['keylist'][0],'id_route'=>$data['keylist'][1],'dept_time'=>$data['keylist'][2],'id_area'=>$data['keylist'][3]])->one()) !== null) {
                echo " ".$modelShuttleTime->shuttle_time_start." <span style='font-size: 10px;' class='fa fa-arrow-right'></span> ".$modelShuttleTime->shuttle_time_end;
            }else{
                echo " Unknown";
            }
            
        }
    }

    public function actionDetailModal($id_booking){
        $modelBooking = $this->findModel($id_booking);
        if(Helper::checkRoute('/booking/*')){
            return $this->renderAjax('_modal-detail-booking',['modelBooking'=>$modelBooking]);
        }else{
            return $this->renderAjax('supplier/_modal-detail-booking',['modelBooking'=>$modelBooking]);
        }
    }

    public function actionCountPassenger(array $var){
        $modelBooking = TBooking::find()->joinWith('idTrip.idBoat')->select('t_booking.id')->where(['t_boat.id_company'=>$var['id_company']])->andWhere(['t_trip.id_route'=>$var['id_route']])->andWhere(['t_trip.date'=>$var['date']])->andWhere(['t_trip.dept_time'=>$var['dept_time']])->andWhere(['between','id_status',TBooking::STATUS_PAID,TBooking::STATUS_REFUND_FULL])->all();
        foreach ($modelBooking as $key => $value) {
            $jumlahPax[] = count($value->affectedPassengers);
        }
        return array_sum($jumlahPax);

    }

    public function actionCountBooking(array $var){
        $modelBooking = TBooking::find()->joinWith('idTrip.idBoat')->where(['t_boat.id_company'=>$var['id_company']])->andWhere(['t_trip.id_route'=>$var['id_route']])->andWhere(['t_trip.date'=>$var['date']])->andWhere(['t_trip.dept_time'=>$var['dept_time']])->andWhere(['between','id_status',TBooking::STATUS_PAID,TBooking::STATUS_REFUND_FULL])->count();
        return $modelBooking;

    }
    public function actionDetail(){
        if (isset($_POST['expandRowKey'])) {
            $model = $this->findModel($_POST['expandRowKey']);
            $modelBooking = TBooking::getBookingGroupPayment($model);
           //$modelPassenger = TPassenger::find();
            return $this->renderAjax('_detail-booking', [
                'modelBooking'=>$modelBooking,
                //'modelPassenger'=> $modelPassenger,
                //'mode'
                ]);
        } else {
            return '<div class="alert alert-danger">Data Not Found</div>';
        }
    }

    protected function findOneBookingArray($id){
        if (($modelBooking = TBooking::find()->where(['id'=>$id])->asArray()->one()) !== null) {
            return $modelBooking;
        }else{
            throw new Exception("Error Processing Request");
            
        }
    }

    protected function findAllRoute(){
        return TRoute::find()->all();
    }

    public function actionSummary(){
        if (Yii::$app->request->isAjax) {
           
            $Booking = TBooking::find()->joinWith('idTrip.idBoat.idCompany');
            if (Helper::checkRoute('/booking/*')) {
                 $Route = $this->findAllRoute();
                $Booking->where('id_status > :zero',[':zero'=>0]);
                foreach ($Route as $key => $value) {
                $result = $Booking->andWhere('t_trip.id_route = :idroute',[':idroute'=>$value->id])->all();
                echo '<li class=" col-xs-6 list-group-item material-list-group__item material-list-group__item">
                '.$value->departureHarbor->name.' -> '.$value->arrivalHarbor->name.'
                <span class="pull-right label label-primary material-label material-label_sm material-label_primary main-container__column">'.count($result).'</span>
                </li>';
            }
            }
            /*else{
                $user = Yii::$app->user->identity->id;
                $Trip = TTrip::find()->joinWith('idBoat.idCompany')->where('t_company.id_user = :iduser',[':iduser'=>$user])->groupBy('id_route')->all();
                $Booking->where('t_company.id_user = :iduser',[':iduser'=>$user])->andWhere(['between','id_status',4,5]);

                foreach ($Trip as $x => $val) {
                $Route = TRoute::findOne($val->id_route);
                $result = $Booking->andWhere('t_trip.id_route = :idroute',[':idroute'=>$Route->id])->all();
                echo '<li class=" col-xs-6 list-group-item material-list-group__item material-list-group__item">
                '.$Route->departureHarbor->name.' -> '.$Route->arrivalHarbor->name.'
                <span class="pull-right label label-primary material-label material-label_sm material-label_primary main-container__column">'.count($result).'</span>
                </li>';
                 }
            }*/
           
            
          
        }
    }

protected function findAllBooking(){
    if(Helper::checkRoute('/booking/*')){
        return TBooking::find()->where(['between','id_status',4,6])->all();
    }else{
        return TBooking::find()->joinWith('idTrip.idBoat.idCompany')->where(['between','id_status',4,6])->andWhere(['t_company.id_user'=>Yii::$app->user->identity->id])->all();
    }

}
    /**
     * Lists all TBooking models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TBookingSearch();
        $dataProvider = $searchModel->summarySearch(Yii::$app->request->queryParams);
        $findPassengers = TPassenger::find();
        $listCompany = ArrayHelper::map(TCompany::find()->asArray()->all(), 'id', 'name');
        foreach ($this->findAllBooking() as $key => $value) {
            $res[] = $value->id;
        }
        if(Helper::checkRoute('/booking/*')){
            $listDept = ArrayHelper::map(THarbor::find()->all(), 'id', 'name', 'idIsland.island');
            $listBuyer = ArrayHelper::map(TPayment::find()->asArray()->groupBy(['name'])->all(), 'name', 'name');
            $request = Yii::$app->request;
            $table_layout = isset(Yii::$app->request->queryParams['TBookingSearch']['table_layout']) ? Yii::$app->request->queryParams['TBookingSearch']['table_layout'] : null;
            if ($table_layout == $searchModel::LAYOUT_GROUP) {
                $dataProvider->pagination->pageSize=100;
                return $this->render('index-group', [
                    'searchModel'    => $searchModel,
                    'dataProvider'   => $dataProvider,
                    'findPassengers' => $findPassengers,
                    'bookingList'    => isset($res) ? $res : $res = ['empty'=>'empty'],
                    'listDept'       => $listDept,
                    'listCompany'    => $listCompany,
                    'listBuyer'      => $listBuyer,
                ]);
            }else{

                return $this->render('index-flat', [
                    'searchModel'    => $searchModel,
                    'dataProvider'   => $dataProvider,
                    'findPassengers' => $findPassengers,
                    'bookingList'    => isset($res) ? $res : $res = ['empty'=>'empty'],
                    'listDept'       => $listDept,
                    'listCompany'    => $listCompany,
                    'listBuyer'      => $listBuyer,
                ]);
            }
        }else{
            $listDept = ArrayHelper::map(TTrip::find()->joinWith(['idBoat.idCompany','idRoute.departureHarbor'])->where(['t_company.id_user'=>Yii::$app->user->identity->id])->groupBy('id_route')->asArray()->all(), 'idRoute.departure', 'idRoute.departureHarbor.name');
            return $this->render('supplier/index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'findPassengers' => $findPassengers,
                'bookingList' => isset($res) ? $res : $res = ['empty'=>'empty'],
                'listDept' => $listDept,
            ]);
        }
    }

        public function actionValidation()
    {
        $searchModel = new BookingValidate();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('validation', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionValidationAccept(){
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $modelPayment = $this->findPayment($data['id']);
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $modelPayment->setPaymentBookingStatus($modelPayment::STATUS_CONFIRM_NOT_RECEIVED,$modelPayment::STATUS_CONFIRM_RECEIVED);
                $modelPayment->validate();
                $modelPayment->save(false);
                //payment status 3 booking status 4;
                $modelQueue = TMailQueue::addTicketQueue($modelPayment->id);
                $transaction->commit();
                return true;
            } catch(\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }

        }else{
            return $this->goHome();
        }
    }

    protected function findPayment($id){
        if (($modelPayment = TPayment::findOne($id)) !== null) {
            return $modelPayment;
        }else{
            throw new Exception("Error Processing Request");
        }
    }
        public function actionValidationReject(){
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $idPayment = $data['id'];
            $modelPayment = $this->findPayment($data['id']);
            $transaction = Yii::$app->db->beginTransaction();
           try {
                $modelPayment->setPaymentBookingStatus($modelPayment::STATUS_INVALID,$modelPayment::STATUS_INVALID);
                $modelPayment->save(false);
                //payment status 100 booking status 100;
                $transaction->commit();
            } catch(\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }

        }else{
            return $this->goHome();
        }
    }

    protected function findBookingByPayment($idPayment){
        if (($model = TBooking::find()->where(['id_payment'=>$idPayment])->all()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Booking Data does not exist.');
        }
    }

    /**
     * Displays a single TBooking model.
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
     * Creates a new TBooking model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TBooking();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TBooking model.
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
     * Deletes an existing TBooking model.
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
     * Finds the TBooking model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TBooking the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if(Helper::checkRoute('/booking/*')){
            return TBooking::findOne($id);           
        }else{

            return TBooking::find()->joinWith('idTrip.idBoat.idCompany')->where(['t_company.id_user'=>Yii::$app->user->identity->id])->andWhere(['t_booking.id'=>$id])->one();
        }
    }
}
