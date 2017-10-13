<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\TimePicker;
use kartik\widgets\DatePicker;
use yii\helpers\Url;
use kartik\switchinput\SwitchInput;
use kartik\widgets\TouchSpin;
use kato\pickadate\Pickadate;
use mdm\admin\components\Helper;
/* @var $this yii\web\View */
/* @var $model common\models\TTrip */
/* @var $form yii\widgets\ActiveForm */
 
if($model->isNewRecord){
    $model->status = 1;
    $model->stock = 1;
 }else{
    $model->id_company = $model->idBoat->id_company;
}

?>
<script type="text/javascript">
    (".datepicker").pickadate();
</script>
<div class="container ttrip-form">
<div class="col-md-6">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-12">
    <?php 
    $layout3 = <<< HTML
    {input1}
    {separator}
    {input2}
    <span class="input-group-addon kv-date-remove">
        <i id="remove-date-range" class="glyphicon glyphicon-remove"></i>
    </span>
HTML;

$customScript = <<< SCRIPT
    $("#remove-date-range").on('click',function(){
        $("#ttrip-date").val(null);
         $("#ttrip-enddate").val(null);
    })
SCRIPT;
$this->registerJs($customScript, \yii\web\View::POS_READY);
        echo '<center><label class="control-label">Select date range</label></center>';
        echo DatePicker::widget([
            'model' => $model,
            'attribute' => 'date',
            'attribute2' => 'endDate',
            'separator' => '<i class="glyphicon glyphicon-resize-horizontal"></i>',
            'options' => ['placeholder' => 'Start date'],
            'options2' => ['placeholder' => 'End date'],
            'type' => DatePicker::TYPE_RANGE,
            'form' => $form,
            'layout' => $layout3,
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'autoclose' => true,
            ]
        ]);
    ?>
    </div>
    <?php 

    /*
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
    ]);*/
   // } 
    ?>
    <?php if (Helper::checkRoute('/booking/validation')): ?>
    <?= $form->field($model, 'id_company')->dropDownList($listCompany,
        [
            'prompt' => '-> Select Company <-',
            'id'=>'drop-company',
            'onchange'=>'
                var cplv = $("#drop-company").val();
                $.ajax({
                    url: "'.Url::to(["boat-list"]).'",
                    type:"POST",
                    data:{cpn :cplv},
                    success: function (data) {
                        $("#drop-boat").html(data);
                    }
                });'
        ]); ?>
    <?php else: ?>
        <h2> <?= $listCompany->name ?></h2>
    <?php endif; ?>
    <?php if (Helper::checkRoute('/booking/validation')) {
       
       echo $form->field($model, 'id_boat')->dropDownList($listBoat, ['prompt' => '-> Select Company First <-','id'=>'drop-boat']);
    }else{
       echo $form->field($model, 'id_boat')->dropDownList($listBoat, ['prompt' => '-> Select Boat <-','id'=>'drop-boat']);
        }
        ?>
    
        <?= $form->field($model, 'template')->dropDownList($template,
        [
            'prompt' => 'Everyday Trip',
            'id'=>'drop-template',
            'onchange'=>'
                var tmp = $(this).val();
                if (tmp == "") {
                    $("#div-dept-time").show(300);
                }else{
                    $("#div-dept-time").hide(300);
                }

            ',
            
        ]); ?>

    <?= $form->field($model, 'id_route')->dropDownList($listRoute, ['prompt' => '-> Select Route <-','id'=>'drop-route']) ?>
    <?= $form->field($model, 'stock')->widget(TouchSpin::classname(), [
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
<div id="div-dept-time" class="col-sm-3">
    <?= $form->field($model, 'dept_time')->widget(Pickadate::classname(), [
        'isTime' => true,
        'id'=>'end-date',
        'options'=>['id'=>'end-date'],
        'pickadateOptions' => [
            'format'=> 'H:i',
            'formatSubmit'=> 'H:i:00',
            'interval'=>15,
            //'min'=>date('d-m-Y'),
        ],
        ]) ?>
</div>

   
<div class="col-sm-12">
     <?= $form->field($model, 'id_est_time')->dropDownList($est_time,
        [
            'prompt' => '-> Select Est Time <-',
            'id'=>'drop-est-time',
            
        ]); ?>
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
