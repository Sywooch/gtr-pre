<?php

namespace backend\controllers;

use Yii;
use common\models\TShuttleTime;
use app\models\TShuttleTimeSearch;
use common\models\TCompany;
use common\models\TTrip;
use common\models\TRoute;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
/**
 * ShuttleTimeController implements the CRUD actions for TShuttleTime model.
 */
class ShuttleTimeController extends Controller
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

    public function actionListRoute(){
        if (Yii::$app->request->isAjax) {
           $data = Yii::$app->request->post();
           $modelTrip = TTrip::find()->joinWith('idBoat')->select('id_route, id_boat, t_boat.id_company')->where(['t_boat.id_company'=>$data['company']])->groupBy('id_route')->asArray()->all();
           echo "<option value=''>Select Route ...</option>";
            foreach ($modelTrip as $key => $value) {
                if (($modelRoute = TRoute::findOne($value['id_route'])) !== null) {
                   echo "<option value='".$modelRoute->id."'>".$modelRoute->departureHarbor->name."->".$modelRoute->arrivalHarbor->name."</option>";
                }
                
            }
        }
    }

    /**
     * Lists all TShuttleTime models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TShuttleTimeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TShuttleTime model.
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
     * Creates a new TShuttleTime model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TShuttleTime();
        $listCompany = ArrayHelper::map($this->findCompany(), 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'listCompany' => $listCompany,
            ]);
        }
    }

    /**
     * Updates an existing TShuttleTime model.
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
     * Deletes an existing TShuttleTime model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findCompany(){
        return TCompany::find()->asArray()->all();
    }

    protected function findRouteByCompany($id_company){
       $modelTrip = TTrip::find()->joinWith('idBoat')->select('id_route, id_boat, t_boat.id_company')->where(['t_boat.id_company'=>$id_company])->groupBy('id_route')->asArray()->all();
        foreach ($modelTrip as $value) {
            if (($modelRoute = TRoute::find()->joinWith(['departureHarbor','arrivalHarbor AS Arrival'])->select('t_route.id, t_harbor.name')->where(['t_route.id'=>$value[0]['id_route']])->one()) !== null) {
               $listRoute[] = ['id'=>$modelRoute->id,'name'=>$modelRoute->departureHarbor->name." -> ".$modelRoute->arrivalHarbor->name/*, 'island'=>$modelRoute->departureHarbor->idIsland->island*/];
            }
            
        }

        return $list = $listRoute;
    }

    /**
     * Finds the TShuttleTime model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TShuttleTime the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TShuttleTime::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
