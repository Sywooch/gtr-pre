<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kato\pickadate\Pickadate;
use kartik\widgets\DatePicker;
use kartik\widgets\Typeahead;
use mdm\admin\components\Helper;
/* @var $this yii\web\View */
/* @var $model app\models\TBookingSearch */
/* @var $form yii\widgets\ActiveForm */
$template2 = ['template'=>"
                <div class='col-md-2'>{label}\n{input}\n{error}\n{hint}</div>
            "
            ];

?>

<div class="tbooking-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id', [
    'template'=>"
                <div class='col-md-2'>{label}\n{input}\n{error}\n{hint}</div>
            ",
    'addon' => [
        'append' => [
            'content' => Html::button('', [
                        'class'=>'btn btn-default glyphicon glyphicon-remove',
                        'onclick'=>'$("#tbookingsearch-id").val(null)']), 
            'asButton' => true
        ]
    ]
])->widget(Typeahead::classname(), [
    'options' => ['placeholder' => 'Type Booking Code'],
    'pluginOptions' => ['highlight'=>true],
    'dataset' => [
        [
            'local' => $bookingList,
            'limit' => 10
        ]
    ]
]); ?>

    <?= $form->field($model, 'departure',$template2)->dropDownList($listDept, ['id' => 'dept-port','prompt'=>'Select Departure Port']); ?>
    <?= $form->field($model, 'date',$template2)->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'Select Date'],
    'pickerButton' => false,
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
    ]
    ])->label('Trip Date'); ?>
    <?= $form->field($model, 'bookdate',$template2)->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'Select Book Date'],
    'pickerButton' => false,
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
    ]
    ])->label('Book Date'); ?>
    <div class="col-md-4">
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
        $("#tbookingsearch-enddate").val(null);
         $("#tbookingsearch-startdate").val(null);
    })
SCRIPT;
$this->registerJs($customScript, \yii\web\View::POS_READY);
        echo '<center><label class="control-label">Select date range</label></center>';
        echo DatePicker::widget([
            'model' => $model,
            'attribute' => 'startDate',
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

    <?php // echo $form->field($model, 'trip_price',$template2) ?>

    <?php // echo $form->field($model, 'total_price',$template2) ?>

    <?php // echo $form->field($model, 'currency',$template2) ?>

    <?php // echo $form->field($model, 'total_idr',$template2) ?>

    <?php // echo $form->field($model, 'exchange',$template2) ?>

    <?php // echo $form->field($model, 'id_status',$template2) ?>

    <?php // echo $form->field($model, 'id_payment_method',$template2) ?>

    <?php // echo $form->field($model, 'send_amount',$template2) ?>

    <?php // echo $form->field($model, 'token',$template2) ?>

    <?php // echo $form->field($model, 'process_by') ?>

    <?php // echo $form->field($model, 'expired_time') ?>

    <?php // echo $form->field($model, 'datetime') ?>

    <div class="form-group col-md-12">
    <?php  if(Helper::checkRoute('/booking/createss')): ?>

        <?= Html::a('', ['create'], ['class' => 'btn material-btn material-btn_danger main-container__column material-btn_lg glyphicon glyphicon-plus']) ?>

    <?php endif; ?>
        <?= Html::submitButton(' ', ['class' => 'btn material-btn material-btn_primary main-container__column material-btn_lg glyphicon glyphicon-search']) ?>
        <?= Html::a('',['index'], ['class' => 'btn material-btn material-btn_success main-container__column material-btn_lg glyphicon glyphicon-refresh']) ?>
  

      </div>
    <?php ActiveForm::end(); ?>

</div>
