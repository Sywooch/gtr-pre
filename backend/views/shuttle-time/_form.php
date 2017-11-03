<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
/* @var $this yii\web\View */
/* @var $model common\models\TShuttleTime */
/* @var $form yii\widgets\ActiveForm */
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
            'prompt'=>'-> Select Company First <-',
            'onchange'=>'
                var vcompany = $(this).val();
                $.ajax({
                    url: "'.Url::to(["list-dept-time"]).'",
                    type:"POST",
                    data:{company :vcompany},
                    success: function (data) {
                        $("#drop-route").html(data);
                    }
                });
            '
            ]); 
    }else{
        echo $form->field($model, 'id_route')->dropdownList($listRoute,['id'=>'drop-route']); 
    }

    ?>

    <?= $form->field($model, 'dept_time')->textInput() ?>

    <?= $form->field($model, 'id_area')->textInput() ?>

    <?= $form->field($model, 'shuttle_time')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
