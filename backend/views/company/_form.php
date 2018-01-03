<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use kartik\switchinput\SwitchInput;
use kartik\label\LabelInPlace;
use kartik\widgets\Select2;
/* @var $this yii\web\View */
/* @var $model common\models\TCompany */
/* @var $form yii\widgets\ActiveForm */
$layout = ['template'=>"{input}\n{error}\n{hint}"];
?>

<div class="tcompany-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name',$layout)->widget(LabelInPlace::classname(),
                [
               
                'class'=>'form-control name',
                'defaultIndicators'=>false,
                'encodeLabel'=> false,
                'label'=>'<i class="glyphicon glyphicon-card"></i> Company Name',
                ]
                );
        ?>

    <?= $form->field($model, 'address',$layout)->widget(LabelInPlace::classname(),
                [
               
                'class'=>'form-control address',
                'defaultIndicators'=>false,
                'encodeLabel'=> false,
                'label'=>'<i class="glyphicon glyphicon-marker"></i> Company Address',
                ]
                );
        ?>

    <?= $form->field($model, 'email_bali',$layout)->widget(LabelInPlace::classname(),
                [
               
                'class'=>'form-control mail-bali',
                'defaultIndicators'=>false,
                'encodeLabel'=> false,
                'label'=>'<i class="glyphicon glyphicon-envelope"></i> Company Email On Bali (Required)',
                ]
                );
        ?>

    <?= $form->field($model, 'email_gili',$layout)->widget(LabelInPlace::classname(),
                [
               
                'class'=>'form-control gili-mail',
                'defaultIndicators'=>false,
                'encodeLabel'=> false,
                'label'=>'<i class="glyphicon glyphicon-envelope"></i> Company Email On Gili/Lombok (Optional)',
                ]
                );
        ?>
    <?= $form->field($model, 'email_cc',$layout)->widget(LabelInPlace::classname(),
                [
               
                'class'=>'form-control cc-mail',
                'defaultIndicators'=>false,
                'encodeLabel'=> false,
                'label'=>'<i class="glyphicon glyphicon-envelope"></i> Company CC Email (Optional)',
                ]
                );
        ?>

    <?php 
    if ($model->isNewRecord) {
         echo $form->field($model, 'logo')->widget(FileInput::classname(), [
    'options' => [
    
    'multiple'=>false,
    'accept' => 'image/*',
   // 'resizeImages'=>true,
    ],
    
])->label(false);;
    }else{
   echo $form->field($model, 'logo')->widget(FileInput::classname(), [
    'options' => [

    'multiple'=>false,
    'accept' => 'image/*',
   // 'resizeImages'=>true,
    ],
    'pluginOptions'=>[
        'initialPreview'=>[
           '/company/logo?logo='.$model->logo_path,
        ],
        'initialPreviewAsData'=>true,
        'initialCaption'=>"Company Logo",
    ],
    
])->label(false);
} ?>

    <?= $form->field($model, 'phone',$layout)->widget(LabelInPlace::classname(),
                [
               
                'class'=>'form-control phone',
                'defaultIndicators'=>false,
                'encodeLabel'=> false,
                'label'=>'<i class="glyphicon glyphicon-phone"></i> Company Phone',
                ]
                );
        ?>
    <?= $form->field($model, 'id_user',$layout)->widget(Select2::classname(), [
                                'data' => $avaibleUser,
                                'options' => ['placeholder' => 'Select User For This Company'],
                                'pluginOptions' => [
                                'allowClear' => true
                                ],
                                ])
     ?>
    <?= $form->field($model, 'id_pod')->widget(SwitchInput::classname(), ['type' => SwitchInput::CHECKBOX,
        'options'=>[
        'uncheck' =>2,
        'value'=>1,
         ],
         'pluginOptions'=>[
       // 'handleWidth'=>60,
        'onText'=>'Yes',
        'offText'=>'No'
         ],
         ]); ?>
    <div class="form-group">
        <?= Html::submitButton(' Save', ['class' => 'btn material-btn material-btn_warning main-container__column material-btn_lg glyphicon glyphicon-saved']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
