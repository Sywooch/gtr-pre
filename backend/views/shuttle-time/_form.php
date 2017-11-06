<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use kato\pickadate\Pickadate;
/* @var $this yii\web\View */
/* @var $model common\models\TShuttleTime */
/* @var $form yii\widgets\ActiveForm */
$layout6 = ['template'=>"<div class=\"row col-md-3\">{label}\n{input}\n{error}\n{hint}</div>"]
?>

<div class="tshuttle-time-form">

    <?php $form = ActiveForm::begin(); ?>

    
    <?= $form->field($model, 'id_company')->widget(Select2::classname(), [
    'data' => $listCompany,
    'options' => [
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
    <?php 
    if ($model->isNewRecord) {
        echo $form->field($model, 'id_route')->dropdownList([],[
            'id'=>'drop-route',
            'prompt'=>'Select Company First..',
            'onchange'=>'
                var vcompany = $("#drop-company").val();
                var vroute   = $(this).val();
                $.ajax({
                    url: "'.Url::to(["list-dept-time"]).'",
                    type:"POST",
                    data:{company :vcompany, route: vroute},
                    success: function (data) {
                        $("#drop-dept-time").html(data);
                    }
                });
            '
            ]);
        echo $form->field($model, 'dept_time')->dropdownList([],[
            'id'=>'drop-dept-time',
            'prompt'=>'Select Company And Route First..',
            'onchange'=>'
                var vtime = $(this).val();
                var vcompany = $("#drop-company").val();
                var vroute   = $("#drop-route").val();
                if (vtime != "" && vcompany != "" && vroute != "") {
                    $.ajax({
                    url: "'.Url::to(["list-shuttle-area"]).'",
                    type:"POST",
                    data:{company :vcompany, route: vroute, time: vtime},
                    success: function (data) {
                        $("#drop-area").html(data);
                    }
                });
                }else{
                    alert("Woke");
                }
                '
            ]);  
    }else{
        echo $form->field($model, 'id_route')->dropdownList($listRoute,['id'=>'drop-route']);
        echo $form->field($model, 'dept_time')->dropdownList($listDeptTime,['id'=>'drop-dept-time']); 
    }

    ?>

    <?= $form->field($model, 'id_area')->dropdownList($listArea,['id'=>'drop-area']);
     ?>

    <?= $form->field($model, 'shuttle_time_start',$layout6)->widget(Pickadate::classname(), [
        'isTime' => true,
        'id'=>'shuttle-time-start',
        'options'=>['id'=>'shuttle-time-start'],
        'pickadateOptions' => [
            'format'=> 'H:i',
            'formatSubmit'=> 'H:i:00',
            'interval'=>15,
        ],
    ]) ?>
    <?= $form->field($model, 'shuttle_time_end',$layout6)->widget(Pickadate::classname(), [
        'isTime' => true,
        'id'=>'shuttle-time-end',
        'options'=>['id'=>'shuttle-time-end'],
        'pickadateOptions' => [
            'format'=> 'H:i',
            'formatSubmit'=> 'H:i:00',
            'interval'=>15,
        ],
    ]) ?>

    <div class="form-group col-md-12">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
