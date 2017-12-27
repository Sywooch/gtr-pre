<?php

namespace backend\controllers;

use Yii;
use common\models\TPrivateTrip;
use backend\models\TPrivateTripSearch;
use common\models\TTime;
use common\models\TEstTime;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\TPrivateRoute;
use yii\helpers\ArrayHelper;

/**
 * PrivateTripController implements the CRUD actions for TPrivateTrip model.
 */
class PrivateTripController extends Controller
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
     * Lists all TPrivateTrip models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TPrivateTripSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TPrivateTrip model.
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
     * Creates a new TPrivateTrip model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TPrivateTrip();
        foreach ($this->findAllRoute() as $key => $value) {
            $array[] = ['id'=>$value['id'],'from'=>$value['fromRoute']['location']." to ".$value['toRoute']['location']];
        }
        $listRoute = ArrayHelper::map($array, 'id', 'from');
        $listTime = ArrayHelper::map(TTime::find()->asArray()->all(), 'id', 'time');
        $listEstTime = ArrayHelper::map(TEstTime::find()->asArray()->all(), 'id', 'est_time');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model'       => $model,
                'listRoute'   => $listRoute,
                'listTime'    => $listTime,
                'listEstTime' => $listEstTime,
            ]);
        }
    }

    protected function findAllRoute(){
        return TPrivateRoute::find()->joinWith(['fromRoute AS fromRoute','toRoute'])->orderBy(['t_private_location.location'=>SORT_ASC])->asArray()->all();
    }
    protected function findListTime(){
        return TTime::find()->asArray()->all();
    }

    /**
     * Updates an existing TPrivateTrip model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
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
     * Deletes an existing TPrivateTrip model.
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
     * Finds the TPrivateTrip model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TPrivateTrip the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TPrivateTrip::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
