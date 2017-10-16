<?php

namespace backend\controllers;

use Yii;
use common\models\TBooking;
use common\models\TSeasonPriceSet;
use common\models\TSeasonPriceSetSearch;
use common\models\TCompany;
use common\models\TRoute;
use common\models\TTrip;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii\helpers\ArrayHelper;

/**
 * SetSeasonController implements the CRUD actions for TSeasonPriceSet model.
 */
class SetSeasonController extends Controller
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
     * Lists all TSeasonPriceSet models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TSeasonPriceSetSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TSeasonPriceSet model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findCompany(){
        return TCompany::find();
    }
    protected function findRoute(){
        return TRoute::find();
    }

    /**
     * Creates a new TSeasonPriceSet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TSeasonPriceSet();
        $listCompany = ArrayHelper::map($this->findCompany()->all(), 'id', 'name');
        $list = $this->findRoute()->orderBy(['departure'=>SORT_ASC])->all();
            foreach ($list as $key => $value) {
                $arrayRoute[$key]= ['id'=>$value->id, 'route'=>$value->departureHarbor->name." -> ".$value->arrivalHarbor->name]; 
            }
        $listRoute = ArrayHelper::map($arrayRoute,'id', 'route');
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
             $this->generatePrice($model);
            return $this->redirect('index');
        } else {
            return $this->render('create', [
                'model' => $model,
                'listCompany'=>$listCompany,
                'listRoute'=>$listRoute,
                
            ]);
        }
    }

//->andWhere('adult_price != :adult_price',[':adult_price'=> null])->andWhere('child_price != :child_price',[':child_price'=>null])

    protected function generatePrice($model){
     
        if (($trip = TTrip::find()->joinWith('idBoat')->where('t_boat.id_company = :id_company',[':id_company'=>$model->id_company])->andWhere(['id_route'=>$model->id_route])->andWhere(['between', 'date', $model->start_date, $model->end_date])->andWhere(['id_price_type'=>1])->all()) !== null )  {
            foreach ($trip as $key => $value) {
                $value->adult_price   = $model->adult_price;
                $value->child_price   = $model->child_price;
                $value->id_season     = $model->id;
                $value->id_price_type = '1';
                $value->validate();
                $value->save(false);
            }
        }
        if(($trip = TTrip::find()->joinWith('idBoat')->where('t_boat.id_company = :id_company',[':id_company'=>$model->id_company])->andWhere(['id_route'=>$model->id_route])->andWhere(['between', 'date', $model->start_date, $model->end_date])->andWhere(['id_price_type'=>NULL])->all()) !== null )  {
            foreach ($trip as $key => $value) {
                $value->adult_price   = $model->adult_price;
                $value->child_price   = $model->child_price;
                $value->id_season     = $model->id;
                $value->id_price_type = '1';
                $value->validate();
                $value->save(false);
            }
        }

        return true;
        
    }

    /**
     * Updates an existing TSeasonPriceSet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $listCompany = ArrayHelper::map($this->findCompany()->all(), 'id', 'name');
        $list = $this->findRoute()->orderBy(['departure'=>SORT_ASC])->all();
            foreach ($list as $key => $value) {
                $arrayRoute[$key]= ['id'=>$value->id, 'route'=>$value->departureHarbor->name." -> ".$value->arrivalHarbor->name]; 
            }
        $listRoute = ArrayHelper::map($arrayRoute,'id', 'route');
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            $this->generatePrice($model);
            return $this->redirect('index');
        } else {
            return $this->render('update', [
                'model' => $model,
                'listCompany'=>$listCompany,
                'listRoute'=>$listRoute,
            ]);
        }
    }

    /**
     * Deletes an existing TSeasonPriceSet model.
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
     * Finds the TSeasonPriceSet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TSeasonPriceSet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TSeasonPriceSet::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
