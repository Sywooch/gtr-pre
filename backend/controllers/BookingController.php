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

    protected function findAllRoute(){
        return TRoute::find()->all();
    }

    public function actionSummary(){
        if (Yii::$app->request->isAjax) {
            $Route = $this->findAllRoute();
            $Booking = TBooking::find()->joinWith('idTrip.idBoat.idCompany');
            if (Helper::checkRoute('/*')) {
                $Booking->where('id_status > :zero',[':zero'=>0]);
            }else{
                $Booking->where('t_company.id_user = :iduser',[':iduser'=>Yii::$app->user->identity->id]);
            }
            foreach ($Route as $key => $value) {
                $result = $Booking->andWhere('t_trip.id_route = :idroute',[':idroute'=>$value->id])->all();
                echo '<li class=" col-xs-6 list-group-item material-list-group__item material-list-group__item">
                '.$value->departureHarbor->name.' -> '.$value->arrivalHarbor->name.'
                <span class="pull-right label label-primary material-label material-label_sm material-label_primary main-container__column">'.count($result).'</span>
                </li>';
            }
          
        }
    }

protected function findAllBooking(){
    return TBooking::find()->all();
}
    /**
     * Lists all TBooking models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TBookingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $findPassengers = TPassenger::find();
        $portModel = THarbor::find()->all();

        foreach ($portModel as $key => $value) {
            $arrayHarbor[] = ['id'=>$value->id,'name'=>$value->name,'island'=>$value->idIsland->island];
        }
        $listDept = ArrayHelper::map($arrayHarbor, 'id', 'name', 'island');

       // $bookingList = ;
        foreach ($this->findAllBooking() as $key => $value) {
            $res[] = $value->id;
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'findPassengers' => $findPassengers,
            'bookingList' => isset($res) ? $res : $res = ['empty'=>'empty'],
            'listDept' => $listDept,
        ]);
    }

        public function actionValidation()
    {
        $searchModel = new BookingValidate();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $findPassengers = TPassenger::find();
        return $this->render('validation', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'findPassengers' => $findPassengers,
        ]);
    }

    public function actionValidationAccept(){
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $idPayment = $data['id'];
            $bookingList = $this->findBookingByPayment($idPayment);
            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($bookingList as $x => $val) {
                    $val->id_status = '4';
                    $val->validate();
                    $val->save(false);
                }
                 $modelQueue                               = new TMailQueue();
                 $modelQueue->id_payment                   = $idPayment;
                 $modelQueue->status                       = '1';
                 $modelQueue->id_type                      = '1';
                 $modelQueue->validate();
                 $modelQueue->save(false);
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

        public function actionValidationReject(){
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $idPayment = $data['id'];
            $bookingList = $this->findBookingByPayment($idPayment);
            $transaction = Yii::$app->db->beginTransaction();
            try {
                foreach ($bookingList as $x => $val) {
                    $val->id_status = '100';
                    $val->validate();
                    $val->save(false);
                }
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
        if (($model = TBooking::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
