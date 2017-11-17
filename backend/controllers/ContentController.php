<?php

namespace backend\controllers;

use Yii;
use common\models\TContent;
use common\models\TTypeContent;
use common\models\TBooking;
use app\models\ContentSearch;
use common\models\TGalery;
use common\models\TCompany;
use common\models\TContentCompany;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

/**
 * ContentController implements the CRUD actions for TContent model.
 */
class ContentController extends Controller
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

         public function actionThumbnail($id)
    {
        $model = $this->findModel($id);
        $response = Yii::$app->getResponse();
        return $response->sendFile($model->thumbnail,'thumbnail.jpg', [
                //'mimeType' => 'image/jpg',
               //'fileSize' => '386',
                'inline' => true
        ]);
    }

    public function actionFollowUp($id){
        if (Yii::$app->request->isPost){
            $modelContent = $this->findModel($id);
            $modelContent->updated_at = strtotime(date('M d, Y h:i:s A'));
            $modelContent->save(false);
            return $this->redirect(['index']);
        }else{
            return $this->goHome();
        }
    }

    public function actionSlug(){
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $title = $data['title'];
            echo strtolower(str_replace(" ", "-", $title));
        }else{
            return $this->goHome();
        }
    }

    /**
     * Lists all TContent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ContentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $modelContent = TContent::find()->orderBy(['id_type_content'=>SORT_ASC])->all();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelContent' => $modelContent,
        ]);
    }

    /**
     * Displays a single TContent model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TContent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TContent();
        $listType = ArrayHelper::map($this->findAllType(), 'id', 'type');
        $listSlug = ArrayHelper::map($this->findAllSlug(), 'slug', 'slug');
        $listKeywords = ArrayHelper::map($this->findAllSlug(), 'keywords', 'keywords');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->keywords = join(', ',$model->keywords);
                $model->thumb = UploadedFile::getInstance($model, 'thumb');
                if ($model->thumb != null) {
               // $model->saveThumbnail($model->slug);
                $path = Yii::$app->basePath.'/content/'.$model->slug.'/';
                FileHelper::createDirectory($path, $mode = 0777, $recursive = true);
                $model->thumbnail = $path.$model->thumb->baseName.'.'.$model->thumb->extension;
                $model->save(false);
                $model->thumb->saveAs($path.$model->thumb->baseName.'.'.$model->thumb->extension);
                }else{
                    $model->save(false);
                }
                $transaction->commit();
                return $this->redirect(['index']);
                
            } catch(\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
            
        } else {
            return $this->render('create', [
                'model' => $model,
                'listType' => $listType,
                'listSlug' => $listSlug,
                'listKeywords' => $listKeywords,
            ]);
        }
    }
    public function actionCreateFastboat()
    {
        $model                       = new TContent();
        $modelContentCompany         = new TContentCompany();
        $modelGalery                 = new TGalery();
        $listType                    = ArrayHelper::map($this->findAllCompany(), 'id', 'name');
        $listKeywords                = ArrayHelper::map($this->findContentByColumn("keywords"), 'keywords', 'keywords');
        $model->id_type_content      = '1';
        $modelGalery->id_type_galery = '1';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->keywords = join(', ',$model->keywords);
                $model->thumb = UploadedFile::getInstance($model, 'thumb');
                if ($model->thumb != null) {
               // $model->saveThumbnail($model->slug);
                $path = Yii::getAlias('@frontend').'/content/'.$model->slug.'/';
                FileHelper::createDirectory($path, $mode = 0777, $recursive = true);
                $model->thumbnail = $path.$model->thumb->baseName.'.'.$model->thumb->extension;
                $model->save(false);
                $model->thumb->saveAs($path.$model->thumb->baseName.'.'.$model->thumb->extension);
                //$modelGalery->
                }else{
                    $model->save(false);
                }
                $transaction->commit();
                return $this->redirect(['index']);
                
            } catch(\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
            
        } else {
            return $this->render('_form-fastboat', [
                'model'               => $model,
                'listType'            => $listType,
                'listKeywords'        => $listKeywords,
                'modelContentCompany' => $modelContentCompany,
                'modelGalery'         => $modelGalery,
            ]);
        }
    }
    protected function findAllCompany(){
        return TCompany::find()->select('id,name')->asArray()->all();
    }
    protected function findContentByColumn($column){
        return TContent::find()->select($column)->asArray()->all();
    }
    protected function findAllSlug(){
        return TContent::find()->all();
    }

    protected function findAllType(){
        if (($model = TContent::find()->where(['id_type_content'=>5])->one()) !== null) {
            if ($model->id_type_content == 5) {
                return TTypeContent::find()->all();
            }else{
                return TTypeContent::find()->where(['!=','id',5])->all();
            }
        }else{
        return TTypeContent::find()->all();
        }
    }

    /**
     * Updates an existing TContent model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $listType = ArrayHelper::map($this->findAllType(), 'id', 'type');
        $listSlug = ArrayHelper::map($this->findAllSlug(), 'slug', 'slug');
        $listKeywords = ArrayHelper::map($this->findAllSlug(), 'keywords', 'keywords');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->keywords = join(', ',$model->keywords);
                $model->thumb = UploadedFile::getInstance($model, 'thumb');
                if ($model->thumb != null) {
                    if (file_exists($model->thumbnail)) {
                       unlink($model->thumbnail);
                    }
                    
                    $path = Yii::$app->basePath.'/content/'.$model->slug.'/';
                    FileHelper::createDirectory($path, $mode = 0777, $recursive = true);
                    $model->thumbnail = $path.$model->thumb->baseName.'.'.$model->thumb->extension;
                    $model->save(false);
                    $model->thumb->saveAs($path.$model->thumb->baseName.'.'.$model->thumb->extension);
                }else{
                    $model->save(false);
                }
               
                
                $transaction->commit();
                return $this->redirect(['index']);
                
            } catch(\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
            
        } else {
            return $this->render('update', [
                'model' => $model,
                'listType' => $listType,
                'listSlug' => $listSlug,
                'listKeywords' => $listKeywords,
            ]);
        }
    }

    /**
     * Deletes an existing TContent model.
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
     * Finds the TContent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TContent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TContent::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
