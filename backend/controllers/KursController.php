<?php

namespace backend\controllers;

use Yii;
use common\models\TKurs;
use common\models\TKursSearch;
use common\models\TMailQueue;
use common\models\TPassenger;
use common\models\TBooking;
use common\models\TShuttleLocationTmp;
use common\models\TPayment;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;
use yii\helpers\FileHelper;

/**
 * KursController implements the CRUD actions for TKurs model.
 */
class KursController extends Controller
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

    public function beforeAction($action)
    {    
        if ($action->id == 'kurs') {
            $this->enableCsrfValidation = false;
            return parent::beforeAction($action);
        }else{
            return true;
        }    
    }


protected function findPassenger(){
        return TPassenger::find();
    }

    protected function findShuttle(){
        return TShuttleLocationTmp::find();
    }

     public function actionKurs(){
        

        $modelQueue = TMailQueue::find()->where(['status'=>1])->orderBy(['datetime'=>SORT_DESC])->one();
        if ($modelQueue != null) {
            $modelPayment = TPayment::findOne($modelQueue->id_payment);
            $modelBooking = TBooking::find()->where(['id_payment'=>$modelPayment->id])->all();
            $findShuttle = $this->findShuttle();
            $findPassenger = $this->findPassenger();
            $savePath =  Yii::$app->basePath."/E-Ticket/".$modelPayment->token."/";
            FileHelper::createDirectory ( $savePath, $mode = 0777, $recursive = true );
            $Ticket = new Pdf([
            'filename'=>$savePath.'E-Ticket.pdf',
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // simpan file
            'destination' => Pdf::DEST_FILE,
            'content' => "
                ".$this->renderAjax('/email-ticket/pdf-ticket',[
                    'modelBooking'=>$modelBooking,
                    'modelPayment'=>$modelPayment,
                    'findShuttle'=>$findShuttle,
                    'findPassenger'=>$findPassenger,
                    ])." ",
                            // any css to be embedded if required
                            'cssInline' => '.kv-heading-1{
                                                font-size:18px
                                            }
                                            .judul{
                                                font-size:25px;
                                            }
                                            @media print{
                                                .page-break{display: block;page-break-before: always;}
                                            }
                                            '
                                            , 
                            //set mPDF properties on the fly
                            'options'   => ['title' => 'E-Ticket Traviora'],
                            // call mPDF methods on the fly
                            'methods'   => [ 
                            'SetHeader' =>['E-Ticket Gilitransfers'], 
                            'SetFooter' =>['Please take this Ticket on your trip as a justification'],
                    ]
                ]);
                $Ticket->render();
                $Receipt = new Pdf([
                'filename'=>$savePath.'Receipt.pdf',
                // A4 paper format
                'format' => Pdf::FORMAT_A4, 
                // portrait orientation
                'orientation' => Pdf::ORIENT_PORTRAIT, 
                // simpan file
                'destination' => Pdf::DEST_FILE,
                'content' => "
                    ".$this->renderAjax('/email-ticket/pdf-receipt',[
                        'modelBooking'=>$modelBooking,
                        'modelPayment'=>$modelPayment,
                        'findPassenger'=>$findPassenger,
                        ])." ",
                                // any css to be embedded if required
                                'cssInline' => '.kv-heading-1{
                                                    font-size:18px
                                                }
                                                .judul{
                                                    font-size:25px;
                                                }', 
                                //set mPDF properties on the fly
                                'options'   => ['title' => 'Receipt Gilitransfers'],
                                // call mPDF methods on the fly
                                'methods'   => [ 
                                'SetHeader' =>['Receipt Gilitransfers'], 
                                'SetFooter' =>['This receipt automatically printed by system and doesnt require a signature'],
                        ]
                    ]); $Receipt->render();
                Yii::$app->mailReservation->compose()->setFrom('reservation@gilitransfers.com')
                ->setTo($modelPayment->email)
                ->setBcc('istanatravel94@gmail.com')
                ->setSubject('E-Ticket GiliTransfers')
                ->setHtmlBody($this->renderAjax('/email-ticket/email-ticket',[
                    'modelBooking'=>$modelBooking,
                    'modelPayment'=>$modelPayment,
                    ]))
                ->attach($savePath."E-Ticket.pdf")
                ->attach($savePath."Receipt.pdf")
                ->send();
                foreach ($modelBooking as $key => $value) {
                    $PdfSupplier = new Pdf([
                'filename'=>$savePath.$value->id.'.pdf',
                // A4 paper format
                'format' => Pdf::FORMAT_A4, 
                // portrait orientation
                'orientation' => Pdf::ORIENT_PORTRAIT, 
                // simpan file
                'destination' => Pdf::DEST_FILE,
                'content' => "
                    ".$this->renderAjax('/email-ticket/pdf-supplier',[
                        'modelPayment'  =>$modelPayment,
                        'modelBooking'  =>$value,
                        'findShuttle'   =>$findShuttle,
                        'findPassenger' =>$findPassenger,
                        ])." ",
                                // any css to be embedded if required
                                'cssInline' => '.kv-heading-1{
                                                    font-size:18px
                                                }
                                                .judul{
                                                    font-size:25px;
                                                }', 
                                //set mPDF properties on the fly
                                'options'   => ['title' => 'Receipt Gilitransfers'],
                                // call mPDF methods on the fly
                                'methods'   => [ 
                                'SetHeader' =>['Supplier Reservation Gilitransfers'], 
                                'SetFooter' =>['Document automatically printed by system'],
                        ]
                    ]); $PdfSupplier->render();
                    $attach = $savePath.$value->id.".pdf";

                    if ($value->idTrip->idRoute->departureHarbor->id_island == '2' && $value->idTrip->idBoat->idCompany->email_gili != null) {          
                        $this->sendMailSupplier($value->idTrip->idBoat->idCompany->email_gili, $attach,$value, $modelPayment);
                    }else{
                        $this->sendMailSupplier($value->idTrip->idBoat->idCompany->email_bali, $attach, $value, $modelPayment);
                    }
                    
                }
                $modelQueue->status = '3';
                $modelQueue->save();
                FileHelper::removeDirectory($savePath);
        }else{
            return true;
        }
       
             

    }

    protected function sendMailSupplier($to, $attach,$modelBooking,$modelPayment){
        Yii::$app->mailReservation->compose()->setFrom('reservation@gilitransfers.com')
                    ->setTo($to)
                    ->setSubject('Supplier Reservation GiliTransfers')
                    ->setHtmlBody($this->renderAjax('/email-ticket/email-supplier',[
                        'modelBooking'  =>$modelBooking,
                        'modelPayment'  =>$modelPayment,
                        ]))
                    ->attach($attach)
                    ->send();
        return true;
    }

    /**
     * Lists all TKurs models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TKursSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TKurs model.
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
     * Creates a new TKurs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TKurs();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TKurs model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->currency]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TKurs model.
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
     * Finds the TKurs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TKurs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TKurs::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
