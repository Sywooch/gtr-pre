<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\TimePicker;
use kartik\widgets\DatePicker;
use yii\helpers\Url;
use kartik\switchinput\SwitchInput;
use kartik\widgets\TouchSpin;
/* @var $this yii\web\View */
/* @var $model common\models\TTrip */
/* @var $form yii\widgets\ActiveForm */
if($model->isNewRecord){
    $model->status = 1;
    $modelAvaibility->stok = 1;
 }else{
    $model->id_company = $model->idBoat->id_company;
}
?>

<div class="container ttrip-form">
<div class="col-md-6">
    <?php $form = ActiveForm::begin(); ?>
    <?php // if ($model->isNewRecord) {
         echo '<label class="control-label">Select Date Range To Aplly Trip</label>';
        echo DatePicker::widget([
        'model' => $model,
        'attribute' => 'date',
        'attribute2' => 'endDate',
        'options' => ['placeholder' => 'Start date'],
        'options2' => ['placeholder' => 'End date'],
        'type' => DatePicker::TYPE_RANGE,
        'form' => $form,
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'startDate'=>date('Y-m-d'),
            'autoclose' => true,
        ]
    ]);
   // } 
    ?>
    <?= $form->field($model, 'id_company')->dropDownList($listCompany,
        [
            'prompt' => '-> Select Company <-',
            'id'=>'drop-company',
            'onchange'=>'
                var cplv = $("#drop-company").val();
                $.ajax({
                    url: "'.Url::to("boat-list").'",
                    type:"POST",
                    data:{cpn :cplv},
                    success: function (data) {
                        $("#drop-boat").html(data);
                    }
                });



                '
        ]); ?>

    

    <?php if ($model->isNewRecord) {
        $list=[];
       echo $form->field($model, 'id_boat')->dropDownList($list, ['prompt' => '-> Select Company First <-','id'=>'drop-boat']);
    }else{
       echo $form->field($model, 'id_boat')->dropDownList($listBoat, ['prompt' => '-> Select Boat <-','id'=>'drop-boat']);
        }
        ?>

    <?= $form->field($model, 'id_route')->dropDownList($listRoute, ['prompt' => '-> Select Route <-','id'=>'drop-route']) ?>
    <?= $form->field($modelAvaibility, 'stok')->widget(TouchSpin::classname(), [
    'options' => ['placeholder' => 'Number Of Stock'],
    'pluginOptions' => ['verticalbuttons' => true]
    ]);
    ?>
<!--<div class="col-sm-4">
     /*$form->field($model, 'date')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'Select Date'],
    'pickerButton'=>false,
    'readonly' => true,
    'pluginOptions' => [
        'startDate'=>date('Y-m-d'),
        'todayHighlight' => true,
        'todayBtn' => true,
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd'
    ]
])*/
</div>-->
<div class="col-sm-3">
    <?= $form->field($model, 'dept_time')->widget(TimePicker::classname(), [

        'pluginOptions' => [
            'showSeconds' => false,
            'showMeridian' => false,
            'minuteStep' => 15,
        ]
    ]) ?>
</div>

   
<div class="col-sm-12">
    <?= $form->field($model, 'est_time')->textInput(['placeholder'=>'Lama Perjalanan']) ?>
</div>
<div class="col-sm-12">
    <?= $form->field($model, 'description')->textArea(['maxlength' => true]) ?>
</div>
<div class="col-sm-12">
   <?= $form->field($model, 'status')->widget(SwitchInput::classname(), [
                    'type' => SwitchInput::CHECKBOX,
                    'options'=>['uncheck' => 2,'value'=>1,]
                    ]); ?>
</div>

    <div class="form-group col-sm-12">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
</div>
