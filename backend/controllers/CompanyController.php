<?php

namespace backend\controllers;

use Yii;
use common\models\TBooking;
use common\models\TCompany;
use common\models\TCompanySearch;
use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;

/**
 * CompanyController implements the CRUD actions for TCompany model.
 */
class CompanyController extends Controller
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

  public function actionLogo($logo)
    {
       // $logo = $this->find($id);
        $response = Yii::$app->getResponse();
        return $response->sendFile($logo, 'Logo', [
               // 'mimeType' => 'image',
               // 'fileSize' => $logo->size,
                'inline' => true
        ]);
    }
    /**
     * Lists all TCompany models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TCompanySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TCompany model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

protected function findAvaibleUser(){

}

    /**
     * Creates a new TCompany model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TCompany();
        $avaibleUser = ArrayHelper::map(User::find()->all(), 'id', 'username');
        if ($model->load(Yii::$app->request->post())) {
          try {
                $transaction = Yii::$app->db->beginTransaction();
                    $model->logo = UploadedFile::getInstance($model, 'logo');
                    $path = Yii::$app->basePath.'/company-file/'.$model->name.'/';
                    FileHelper::createDirectory($path, $mode = 0777, $recursive = true);
                    $model->logo_path = $path.$model->logo->baseName.'.'.$model->logo->extension;
                    $model->save();
                    $model->logo->saveAs($model->logo_path);

                $transaction->commit();
                return $this->redirect(['index']);       
            } catch (Exception $e) {
                $transaction->rollback();
                throw $e;
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                 'avaibleUser' => $avaibleUser,
            ]);
        }
    }

    /**
            
                $this->save();
     * Updates an existing TCompany model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
         $avaibleUser = ArrayHelper::map(User::find()->all(), 'id', 'username');
       
        if ($model->load(Yii::$app->request->post())) {
          try {
                $transaction = Yii::$app->db->beginTransaction();
                    $model->logo = UploadedFile::getInstance($model, 'logo');
                if (!empty($model->logo)) {
                    $path = Yii::$app->basePath.'/company-file/'.$model->name.'/';
                    FileHelper::removeDirectory($path);
                    FileHelper::createDirectory($path, $mode = 0777, $recursive = true);
                    $model->logo_path = $path.$model->logo->baseName.'.'.$model->logo->extension;
                    $model->logo->saveAs($model->logo_path);
                }
                    $model->save();
                $transaction->commit();
                return $this->redirect(['index']);       
            } catch (Exception $e) {
                $transaction->rollback();
                throw $e;
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                 'avaibleUser' => $avaibleUser,
            ]);
        }
    }

    /**
     * Deletes an existing TCompany model.
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
     * Finds the TCompany model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TCompany the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TCompany::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
