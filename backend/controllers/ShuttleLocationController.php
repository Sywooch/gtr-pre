<?php

namespace backend\controllers;

use Yii;
use common\models\TBooking;
use common\models\TShuttleLocation;
use common\models\TShuttleLocationSearch;
use common\models\TShuttleArea;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ShuttleLocationController implements the CRUD actions for TShuttleLocation model.
 */
class ShuttleLocationController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        Yii::$app->view->params['bookvalidation'] = count(TBooking::find()->joinWith('idPayment')->where(['t_payment.id_payment_method'=>2])->andWhere(['between','t_booking.id_status',2,3])->all());
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
     * Lists all TShuttleLocation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TShuttleLocationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TShuttleLocation model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findArea(){
        return TShuttleArea::find()->all();
    }

    /**
     * Creates a new TShuttleLocation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TShuttleLocation();
        $listArea = ArrayHelper::map($this->findArea(), 'id', 'area','idIsland.island');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('create', [
                'model' => $model,
                'listArea' => $listArea,
            ]);
        }
    }

    /**
     * Updates an existing TShuttleLocation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
         $listArea = ArrayHelper::map($this->findArea(), 'id', 'area','idIsland.island');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('update', [
                'model' => $model,
                'listArea' => $listArea,
            ]);
        }
    }

    /**
     * Deletes an existing TShuttleLocation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TShuttleLocation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TShuttleLocation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TShuttleLocation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
