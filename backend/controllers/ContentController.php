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
use app\models\UploadGalery;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\helpers\Url;

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

    public function actionGalery($id){
        $modelGalery = $this->findOneGalery($id);
        $response = Yii::$app->getResponse();
        return $response->sendFile($modelGalery['filename'],$modelGalery['name'], [
                //'mimeType' => 'image/jpg',
               'fileSize' => $modelGalery['size'],
                'inline' => true
        ]);
    }
    protected function findOneGalery($id){
        return TGalery::find()->where(['id'=>$id])->asArray()->one();
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

    public function actionUploadGalery(){
        if (Yii::$app->request->isAjax) {
            $session         = Yii::$app->session;
            $files           = $_FILES['TGalery'];
            $id_parent       = $_POST['id_parent'];
            $id_type_galery  = $_POST['id_type_galery'];
            $slug            = $_POST['slug'];
            $type_galery_dir = $_POST['type_galery_dir'];
            $basepath        = Yii::getAlias('@frontend').'/contentImage/'.$type_galery_dir.'/'.$slug.'/galery/';
            FileHelper::createDirectory($basepath, $mode = 0775, $recursive = true);
            move_uploaded_file($files['tmp_name']['galery'][0], $basepath.$files['name']['galery'][0]);
            $modelGalery = new TGalery();
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $modelGalery->name           = $files['name']['galery'][0];
                $modelGalery->filename       = $basepath.$files['name']['galery'][0];
                $modelGalery->size           = $files['size']['galery'][0];
                $modelGalery->id_parent      = $id_parent;
                $modelGalery->id_type_galery = $id_type_galery;
                $modelGalery->save(false);
                $transaction->commit();
            } catch(\Exception $e) {
                $transaction->rollBack();
                unlink($basepath.$files['name']['galery'][0]);
                throw $e;
            }
            return true;

        }else{
            return $this->goHome();
        }
    }

    public function actionAddGalery($id_content){
        $modelContent = $this->findModel($id_content);
        $modelPreview = TGalery::find()->select('id')->where(['id_parent'=>$modelContent->id])->asArray()->all();
        foreach($modelPreview as $index => $modelGalery){
           $galeryPreview[] = [Url::to(['galery','id'=>$modelGalery['id']])];
        }
        $modelGalery = new TGalery();
        if (Yii::$app->request->isPost) {
            return $this->redirect(['index']);
        }else{
            return $this->render('_form-galery', [
                'modelContent' => $modelContent,
                'modelGalery'=>$modelGalery,
                'galeryPreview'=>isset($galeryPreview) ? $galeryPreview : ['/logo.png'],
            ]);
        }
    }

    public function actionSetDirGalery(){
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $session                            = $session       = Yii::$app->session;
            $session['dir_galery.company_name'] = $data['company'];
            $session['dir_galery.slug']         = $data['slug'];
            return true;
        }else{
            return "Something Its Wrong. Try To Reload The Page";
        }
    }

    /**
     * Creates a new TContent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model        = new TContent();
        $modelGalery  = new TGalery();
        $listType     = ArrayHelper::map(TTypeContent::find()->select('id, type')->asArray()->all(), 'id', 'type');
        $listSlug     = ArrayHelper::map($this->findAllSlug(), 'slug', 'slug');
        $listKeywords = ArrayHelper::map($this->findAllSlug(), 'keywords', 'keywords');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            $basepath = Yii::getAlias('@frontend').'/contentImage/FastBoat/'.$model->slug;
            try {
                $model->keywords = join(', ',$model->keywords);
                $model->thumb = UploadedFile::getInstance($model, 'thumb');
                if ($model->thumb != null) {
               // $model->saveThumbnail($model->slug);
               
                $thumbPath = $basepath.'/thumbnail/';
                FileHelper::createDirectory($thumbPath, $mode = 0777, $recursive = true);
                $model->thumbnail = $thumbPath.$model->thumb->baseName.'.'.$model->thumb->extension;
                $model->save(false);
                $model->thumb->saveAs($thumbPath.$model->thumb->baseName.'.'.$model->thumb->extension);

                //$modelGalery->
                }else{
                    $model->save(false);
                }
                $modelGalery->galery = UploadedFile::getInstances($modelGalery, 'galery');
                if ($modelGalery->galery != null) {
                    $galPath = $basepath.'/galery/';
                    FileHelper::createDirectory($galPath, $mode = 0777, $recursive = true);
                    foreach ($modelGalery->galery as $file) {
                        $newGalery                 = new TGalery();
                        $file->saveAs($galPath.$file->baseName.'.'.$file->extension);
                        $newGalery->name           = $file->baseName.'.'.$file->extension;
                        $newGalery->filename       = $galPath.$file->baseName.'.'.$file->extension;
                        $newGalery->size           = $file->size;
                        $newGalery->id_parent      = $model->id;
                        $newGalery->id_type_galery = '1';
                        $newGalery->save(false);
                        
                    }
                    
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
                'modelGalery' => $modelGalery,
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
        $model        = $this->findModel($id);
        $listType     = ArrayHelper::map($this->findAllType(), 'id', 'type');
        $listSlug     = ArrayHelper::map($this->findAllSlug(), 'slug', 'slug');
        $listKeywords = ArrayHelper::map($this->findAllSlug(), 'keywords', 'keywords');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->keywords = join(', ',$model->keywords);
                $model->thumb = UploadedFile::getInstance($model, 'thumb');
                if ($model->thumb != null) {
                    if (file_exists($model->thumbnail)){
                       unlink($model->thumbnail);
                    }
                     $basepath = Yii::getAlias('@frontend').'/contentImage/'.$model->idTypeContent->type.'/'.$model->slug;
                     $thumbPath = $basepath.'/thumbnail/';
                     FileHelper::createDirectory($thumbPath, $mode = 0777, $recursive = true);
                     $model->thumbnail = $thumbPath.$model->thumb->baseName.'.'.$model->thumb->extension;
                     $model->save(false);
                     $model->thumb->saveAs($thumbPath.$model->thumb->baseName.'.'.$model->thumb->extension);
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
