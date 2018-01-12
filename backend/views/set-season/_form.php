<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\TSeasonPriceSet */
/* @var $form yii\widgets\ActiveForm */
$model->isNewRecord ? $model->id_season_type = 1 : $model->id_season_type = $model->id_season_type;
?>

<div class="tseason-price-set-form">
    <?php $form = ActiveForm::begin(['enableClientValidation'=>false]); ?>
<div class="col-md-12">

    <?= $form->field($model, 'id_company')->widget(Select2::classname(), [
    'data' => $listCompany,
    'options'=>[
     'placeholder' => 'Select Company ...',
        'id'=>'drop-company',
        'onchange'=>'
                var vcompany = $("#drop-company").val();
                $.ajax({
                    url: "'.Url::to(["list-route"]).'",
                    type:"POST",
                    data:{company :vcompany},
                    success: function (data) {
                        $("#drop-route").html(data);
                    }
                });',
        ],
    'pluginOptions' => [
        'allowClear' => true
    ],
    ]) ?>
</div>
<div class="col-md-12">
    <?= $form->field($model, 'id_season_type')->radioList([
        '1'=>'Low Season',
        '2'=>'High Season',
        '3'=>'Peak Season',
    ],['id' => 'radio-type-season']); ?>
</div>
<div class="col-md-12">
    <?php 
    if ($model->isNewRecord) {
        echo $form->field($model, 'id_route')->dropdownList([],[
            'id'=>'drop-route',
            'prompt'=>'-> Select Company First <-',
            ]); 
    }else{
        echo $form->field($model, 'id_route')->dropdownList($listRoute,['id'=>'drop-route']); 
    }

    ?>
</div>
<div class="col-md-12">
    <?= $form->field($model, 'adult_price')->widget(MaskedInput::className(), [
    'mask'               => ['99,999','999,999'],
    'clientOptions'      => [
    'removeMaskOnSubmit' => true,
    ]
    ]) ?>
</div>
<div class="col-md-12">
    <?= $form->field($model, 'child_price')->widget(MaskedInput::className(), [
    'mask'               => ['99,999','999,999'],
    'clientOptions'      => [
    'removeMaskOnSubmit' => true,
    ]
    ]) ?>
</div>
<div class="col-md-12">
    <?= $form->field($model, 'infant_price')->widget(MaskedInput::className(), [
    'mask'               => ['99,999','999,999'],
    'clientOptions'      => [
    'removeMaskOnSubmit' => true,
    ]
    ]) ?>
</div>
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
            'attribute' => 'start_date',
            'attribute2' => 'end_date',
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
    <div class="form-group col-md-12">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
