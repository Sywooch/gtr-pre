<?php

namespace backend\controllers;

use Yii;
use common\models\TShuttleTime;
use app\models\TShuttleTimeSearch;
use common\models\TCompany;
use common\models\TTrip;
use common\models\TRoute;
use common\models\TShuttleArea;
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

    public function actionListDeptTime(){
        if (Yii::$app->request->isAjax) {
           $data = Yii::$app->request->post();
           $modelTrip = TTrip::find()->joinWith('idBoat')->select('id_route, dept_time, id_boat, t_boat.id_company')->where(['t_boat.id_company'=>$data['company']])->andWhere(['id_route'=>$data['route']])->groupBy('id_route,dept_time')->asArray()->all();
                echo "<option value=''>Select Dept Time ...</option>";
            foreach ($modelTrip as $key => $value) {
                echo "<option value='".$value['dept_time']."'>".date('H:i',strtotime($value['dept_time']))."</option>";
            }
        }
    }

    public function actionListShuttleArea(){
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $modelShuttleTime = TShuttleTime::find()->select('id_area')->where(['id_company'=>$data['company']])->where(['id_route'=>$data['route']])->andWhere(['dept_time'=>$data['time']])->asArray()->all();
            if (count($modelShuttleTime) != null) {
                foreach ($modelShuttleTime as $key => $value) {
                   $my[] =  ArrayHelper::getValue($modelShuttleTime, ''.$key.'.id_area', $default = null);
                }
                $modelShuttleArea = TShuttleArea::find()->where(['NOT IN','id',array_values($my)])->asArray()->orderBy(['id'=>SORT_ASC])->all();
                if (!empty($modelShuttleArea)) {
                    echo "<option value=''>Select Area ...</option>";
                    foreach ($modelShuttleArea as $key => $value) {
                        echo "<option value='".$value['id']."'>".$value['area']."</option>";
                    }
                }else{
                    echo "<option value=''>All Route Already Inserted</option>";
                }
            }else{
                $modelShuttleArea = TShuttleArea::find()->asArray()->orderBy(['area'=>SORT_ASC])->all();
                if (!empty($modelShuttleArea)) {
                    echo "<option value=''>Select Area ...</option>";
                    foreach ($modelShuttleArea as $key => $value) {
                        echo "<option value='".$value['id']."'>".$value['area']."</option>";
                    }
                }else{
                    echo "<option value=''>All Route Already Inserted</option>";
                }
            }
            
        }
    }

   // protected function findAvai

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
            return $this->redirect(['index']);
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
        $listCompany = ArrayHelper::map($this->findCompany(), 'id', 'name');
        $listArea = ArrayHelper::map(TShuttleArea::find()->asArray()->all(), 'id', 'area', 'idIsland.island');

        //List ROute;
        $modelTrip = TTrip::find()->joinWith('idBoat')->select('id_route, id_boat, t_boat.id_company')->where(['t_boat.id_company'=>$model->id_company])->groupBy('id_route')->asArray()->all();
            foreach ($modelTrip as $key => $value) {
                if (($modelRoute = TRoute::findOne($value['id_route'])) !== null) {
                    $ARoute[] = ['id'=>$modelRoute->id,'route'=>$modelRoute->departureHarbor->name."->".$modelRoute->arrivalHarbor->name,'island'=>$modelRoute->departureHarbor->idIsland->island];
                } 
            }
        $listRoute = ArrayHelper::map($ARoute, 'id', 'route', 'island');
        //List Dept Time
        $modelTrip = TTrip::find()->joinWith('idBoat')->select('id_route, dept_time, id_boat, t_boat.id_company')->groupBy('id_route,dept_time')->asArray()->all();
            foreach ($modelTrip as $key => $value) {
               $ADeptTime[$value['dept_time']] = $value['dept_time'];
            }
        $listDeptTime = $ADeptTime;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'listCompany' => $listCompany,
                'listArea' => $listArea,
                'listRoute' => $listRoute,
                'listDeptTime' => $listDeptTime,
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
