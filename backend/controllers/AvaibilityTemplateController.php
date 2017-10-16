<?php

namespace backend\controllers;

use Yii;
use common\models\TBooking;
use common\models\TAvaibilityTemplate;
use common\models\TAvaibilityTemplateSearch;
use common\models\TCompany;
use common\models\AvaibilityTime;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
/**
 * AvaibilityTemplateController implements the CRUD actions for TAvaibilityTemplate model.
 */
class AvaibilityTemplateController extends Controller
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

    protected function findCompany(){
        return TCompany::find();
    }

    /**
     * Lists all TAvaibilityTemplate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TAvaibilityTemplateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TAvaibilityTemplate model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionRenderForm(){
        if (Yii::$app->request->isAjax) {
        $data = Yii::$app->request->post();
        $attr = $data['attr'];
        $modelDatetime = new AvaibilityTime();
        echo $this->renderPartial('_time',[
            'datetime'=>$attr,
            'modelDatetime'=>$modelDatetime,
            ]);
        }else{
            echo "<h1>METHOD NOT ALLOWED</h1>";
        }
        
    }

    /**
     * Creates a new TAvaibilityTemplate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TAvaibilityTemplate();
       
        $listCompany = ArrayHelper::map($this->findCompany()->all(), 'id', 'name');
        $modelDatetime = new AvaibilityTime();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            /*if (!empty($modelDatetime->load(Yii::$app->request->post()))) {
                $model->time_senin  = $modelDatetime->time_senin;
                $model->time_selasa = $modelDatetime->time_selasa;
                $model->time_rabu   = $modelDatetime->time_rabu;
                $model->time_kamis  = $modelDatetime->time_kamis;
                $model->time_jumat  = $modelDatetime->time_jumat;
                $model->time_sabtu  = $modelDatetime->time_sabtu;
                $model->time_minggu = $modelDatetime->time_minggu;
                
            }*/
            $model->save();
            return $this->redirect('index');
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelDatetime' => $modelDatetime,
                'listCompany'=>$listCompany,
            ]);
        }
    }

    /**
     * Updates an existing TAvaibilityTemplate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

       $listCompany = ArrayHelper::map($this->findCompany()->all(), 'id', 'name');
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            return $this->redirect('index');
        } else {
            return $this->render('update', [
                'model' => $model,
                'listCompany'=>$listCompany,
            ]);
        }
    }

    /**
     * Deletes an existing TAvaibilityTemplate model.
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
     * Finds the TAvaibilityTemplate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TAvaibilityTemplate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TAvaibilityTemplate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
