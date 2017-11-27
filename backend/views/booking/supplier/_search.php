<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use kato\pickadate\Pickadate;
use kartik\widgets\DatePicker;
use kartik\widgets\Typeahead;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\TBookingSearch */
/* @var $form yii\widgets\ActiveForm */
$template2 = ['template'=>"
                <div class='col-md-2 col-sm-4 col-xs-6'>{label}\n{input}\n{error}\n{hint}</div>
            "
            ];

?>

<div class="tbooking-search">
<?php
 
$this->registerJs(
   '$("document").ready(function(){
        $("#pjax-form-search").on("pjax:start", function() {
            $("#loading-pjax").html(\'<img src="/spinner.svg">\');
        }); 
        $("#pjax-form-search").on("pjax:end", function() {
            $.pjax.reload({container:"#pjax-table-booking"});  //Reload GridView
            $("#loading-pjax").empty();

        });
    });
    '
);
?>
<?php yii\widgets\Pjax::begin(['id' => 'pjax-form-search']) ?>
<?php $form = ActiveForm::begin([
        'options' => ['data-pjax' => true ],
        'action'  => ['index'],
        'method'  => 'get',]); ?>

    <?= $form->field($model, 'id', [
    'template'=>"
                <div class='col-md-2 col-sm-4 col-xs-6'>{label}\n{input}\n{error}\n{hint}</div>
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
    <?= $form->field($model, 'id_route',$template2)->dropDownList(ArrayHelper::map(Yii::$app->runAction('/trip/get-avaible-route'), 'id', 'route', 'island'), ['id' => 'drop-route','prompt'=>'Select Route...'])->label('Route'); ?>
    <?php
$this->registerJs('
var vcompany = $("#drop-company").val();
$.ajax({
    url: "'.Url::to(["list-route"]).'",
    type:"POST",
    data:{company :vcompany},
    success: function (data) {
        $("#drop-route").html(data);
    }
});
    ', \yii\web\View::POS_READY);
     ?>
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
    <div class="col-md-4 col-sm-12 col-xs-12">
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
        echo '<center><label class="control-label">Date Range</label></center>';
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
$request = Yii::$app->request;
$rangeType = isset($request->queryParams['TBookingSearch']["rangeType"]) ? $request->queryParams['TBookingSearch']["rangeType"] : '1';
$model->rangeType = $rangeType;

    ?>
<br>
        <?= Html::activeHiddenInput($model, 'rangeType', ['value' => '1']); ?>
    </div>


    <div class="form-group col-md-12 col-sm-12 col-xs-12">
        <?= Html::submitButton(' ', [
                'class' => 'btn material-btn material-btn_primary main-container__column material-btn_lg glyphicon glyphicon-search',
                // 'data-toggle'=>'tooltip',
                // 'title'=>'Apply Filter',
                ]) ?>
        <?= Html::a('',['index'], [
                'class' => 'btn material-btn material-btn_success main-container__column material-btn_lg glyphicon glyphicon-refresh',
                // 'data-toggle'=>'tooltip',
                // 'title'=>'Reset Filter',
                ]) ?>
  

      </div>
    <?php ActiveForm::end(); ?>
<?php yii\widgets\Pjax::end() ?>

</div>
