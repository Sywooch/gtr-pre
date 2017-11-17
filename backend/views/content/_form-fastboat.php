<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\FileInput;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model common\models\TContent */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Create Fastboat Content';
$this->params['breadcrumbs'][] = ['label' => 'Content List', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$layout = ['template'=>"{input}\n{error}\n{hint}"];
$model['keywords'] = explode(",", $model['keywords']);
$list = implode(",", $listKeywords);
$endList = explode(",",$list);

foreach ($endList as $key => $value) {
    $finalList[$value] =[$value=>$value];
}
?>

<div class="tcontent-form">

    <?php $form = ActiveForm::begin([
        'options'=>['enctype'=>'multipart/form-data']
    ]); ?>

    <?= $form->field($modelContentCompany, 'id_company')->dropDownList($listType, ['prompt' => 'Select Fastboat...']); ?>
    <?= $form->field($model, 'title')->textInput([
                        'placeholder'=>'Content Title',
                        'onblur'=>'
                                var ttl = $(this).val();
                                 $.ajax({
                                 url : "'.Url::to(["slug"]).'",
                                 type: "POST",
                                 data: {title: ttl},
                                 success: function (div) {
                                 $("#form-slug").val(div);

                                 },
                               });
                            ',
        ]);
     ?>
    <?= $form->field($model, 'slug')->textInput(['id'=>'form-slug','placeholder'=>'Type Your Unique Slug'])?>

    <?php 
    if ($model->isNewRecord) {
         echo $form->field($model, 'thumb')->widget(FileInput::classname(), [
        'options' => [
        'multiple'=>false,
        'accept' => 'image/*',
        'resizeImages'=>true,
        ],
        'pluginOptions' => [
            'showCaption' => false,
            'showRemove' => true,
            'showUpload' => false,
            'browseClass' => 'btn btn-primary btn-block',
            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
            'browseLabel' =>  'Select Thumbnail'
        ],
    ])->label(false);
    }else{
       echo $form->field($model, 'thumb')->widget(FileInput::classname(), [
        'options' => [

        'multiple'=>false,
        'accept' => 'image/*',
        'resizeImages'=>true,
        ],
        'pluginOptions'=>[
            'initialPreview'=>[
               Url::to(['thumbnail','id'=>$model->id]),
            ],
            'initialPreviewAsData'=>true,
            'initialCaption'=>"Company Logo",
            'showCaption' => false,
            'showRemove' => false,
            'showUpload' => false,
            'browseClass' => 'btn btn-primary btn-block',
            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
            'browseLabel' =>  'Select Thumbnail'
        ],
        
    ]);
    } ?>
    
    
    <?= $form->field($model, 'keywords')->widget(Select2::classname(), [
    'data' => $finalList,
    'options' => ['placeholder' => 'Insert keyword ...', 'multiple' => true,'id'=>'form-keyword'],
    'pluginOptions' => [
        'tags' => true,
        'allowClear'=>true,
        'tokenSeparators' => [','],
        'maximumInputLength' => 100,
    ],
])->label('Keyword ( Pisahkan dengan Koma ) '); ?>
    <?= $form->field($model, 'description')->textArea()
     ?>
    
<?= $form->field($model, 'content')->widget(\yii\redactor\widgets\Redactor::className(), [
    'clientOptions' => [
        'plugins' => [
                'clips',
                'fontcolor',
                //'imagemanager',
                'table',
                'video',
                'clips',
                'fontfamily',
                'fontsize',
                ]
    ]
])?>
<?= $form->field($modelGalery, 'galery[]')->widget(FileInput::classname(), [
        'options' => [
        'multiple'=>true,
        'accept' => 'image/*',
        'resizeImages'=>true,
        ],
        'pluginOptions' => [
            'showCaption' => false,
            'showRemove' => true,
            'showUpload' => false,
            'browseClass' => 'btn btn-warning btn-block',
            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
            'browseLabel' =>  'Select Image For galery'
        ],
    ])->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', ' Save'), ['class' => 'btn material-btn material-btn_primary main-container__column material-btn_lg glyphicon glyphicon-floppy-saved']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
