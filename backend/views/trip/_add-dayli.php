<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\TimePicker;
use kartik\widgets\DatePicker;
use yii\helpers\Url;
use kartik\switchinput\SwitchInput;
use kartik\widgets\TouchSpin;
use mdm\admin\components\Helper;
/* @var $this yii\web\View */
/* @var $model common\models\TTrip */
/* @var $form yii\widgets\ActiveForm */
    $model->status = 1;
    $model->stock = 1;

?>

<div class="container ttrip-form">
<div class="col-md-6">
<h4>Add Trip On = <?= Html::encode(date('l, d-m-Y',strtotime($model->date))); ?></h4>
    <?php $form = ActiveForm::begin(); ?>
    <?php if (Helper::checkRoute('/booking/validation')): ?>
    <?= $form->field($model, 'id_company')->dropDownList($listCompany,
        [
            'prompt' => '-> Select Company <-',
            'id'=>'drop-company',
            'onchange'=>'
                var cplv = $("#drop-company").val();
                $.ajax({
                    url: "'.Url::to("/trip/boat-list").'",
                    type:"POST",
                    data:{cpn :cplv},
                    success: function (data) {
                        $("#drop-boat").html(data);
                    }
                });



                '
        ]); ?>
    <?php else: ?>
        <h3><?= $listCompany->name ?></h3>
    <?php endif; ?>
    

    <?= $form->field($model, 'id_boat')->dropDownList($listBoat, ['prompt' => '-> Select Boat <-','id'=>'drop-boat']);
        ?>

    <?= $form->field($model, 'id_route')->dropDownList($listRoute, ['prompt' => '-> Select Route <-','id'=>'drop-route']) ?>
    <?= $form->field($model, 'stock')->widget(TouchSpin::classname(), [
    'options' => ['placeholder' => 'Number Of Stock'],
    'pluginOptions' => ['verticalbuttons' => true]
    ]);
    ?>
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
