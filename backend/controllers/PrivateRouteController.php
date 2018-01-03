<?php

namespace backend\controllers;

use Yii;
use common\models\TPrivateRoute;
use backend\models\TPrivateRouteSearch;
use common\models\TPrivateLocation;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
/**
 * PrivateRouteController implements the CRUD actions for TPrivateRoute model.
 */
class PrivateRouteController extends Controller
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

    public function actionToRoute(){
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $List = TPrivateLocation::find()->where(['!=','id',$data['id']])->asArray()->orderBy(['location'=>SORT_ASC])->all();
            echo "<option value=''> Select Destination... </option>"; 
            foreach ($List as $key => $value) {
                echo "<option value='".$value['id']."'>".$value['location']."</option>";
            }
        }
    }

    /**
     * Lists all TPrivateRoute models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TPrivateRouteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TPrivateRoute model.
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
     * Creates a new TPrivateRoute model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TPrivateRoute();
        $listLocation = ArrayHelper::map(TPrivateLocation::find()->asArray()->orderBy(['location'=>SORT_ASC])->all(), 'id', 'location');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['create']);
        } else {
            return $this->render('create', [
                'model'        => $model,
                'listLocation' => $listLocation,
            ]);
        }
    }

    protected function findLocationList(){

    }

    /**
     * Updates an existing TPrivateRoute model.
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
     * Deletes an existing TPrivateRoute model.
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
     * Finds the TPrivateRoute model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TPrivateRoute the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TPrivateRoute::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
