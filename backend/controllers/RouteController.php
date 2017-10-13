<?php

namespace backend\controllers;

use Yii;
use common\models\TBooking;
use common\models\TRoute;
use common\models\TRouteSearch;
use common\models\THarbor;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * RouteController implements the CRUD actions for TRoute model.
 */
class RouteController extends Controller
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

    protected function findHarbor(){
        return THarbor::find();
    }

    public function actionArrivalList(){
        if (Yii::$app->request->isAjax) { 
            $data = Yii::$app->request->post();
            $idDept = $data['dpt'];
            $island = $this->findHarbor()->where(['id'=>$idDept])->one();
            $arrival = $this->findHarbor()->where('id_island != :id',[':id'=>$island->id_island])->all();

            echo "<option value=''>- > Select Departure Harbor <-</option>";
            foreach ($arrival as $key => $value) {
                echo "<option value='".$value->id."'>".$value->name."</option>";
            }

        }
    }

    /**
     * Lists all TRoute models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TRouteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TRoute model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TRoute model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TRoute();
        $listHarbor = ArrayHelper::map($this->findHarbor()->all(),'id','name');
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            return $this->redirect('create');
        } else {
            return $this->render('create', [
                'model' => $model,
                'listHarbor'=>$listHarbor,
            ]);
        }
    }

    /**
     * Updates an existing TRoute model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $listHarbor = ArrayHelper::map($this->findHarbor()->all(),'id','name');
       if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            return $this->redirect('create');
        } else {
            return $this->render('update', [
                'model' => $model,
                'listHarbor'=>$listHarbor,
            ]);
        }
    }

    /**
     * Deletes an existing TRoute model.
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
     * Finds the TRoute model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TRoute the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TRoute::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
