<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use kartik\widgets\TimePicker;
use kartik\widgets\DatePicker;
use yii\helpers\Url;
use kartik\switchinput\SwitchInput;
use kartik\widgets\TouchSpin;
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
$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Trip',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Trip List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<div class="container ttrip-form">
<div class="col-md-6">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'Select Date'],
    'pickerButton'=>false,
    'readonly' => true,
    'pluginOptions' => [
        //'startDate'=>date('Y-m-d'),
        'todayHighlight' => true,
        'todayBtn' => true,
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd'
    ]
]);
?>
    <?php if(Helper::checkRoute('/booking/validation')): ?>
    <?= $form->field($model, 'id_company')->dropDownList($listCompany,
        [
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

    

    <?= $form->field($model, 'id_boat')->dropDownList($listBoat, ['prompt' => '-> Select Boat <-','id'=>'drop-boat']);
        ?>
    <?php else:?>
        <h3><?= $model->idBoat->idCompany->name ?></h3>
        <h3><?= $model->idBoat->name ?></h3>
    <?php endif; ?>
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
    <?= $form->field($model, 'id_est_time')->textInput(['placeholder'=>'Lama Perjalanan']) ?>
</div>
<div class="col-sm-12">
    <?= $form->field($model, 'description')->textArea(['maxlength' => true]) ?>
</div>
<?php if (Helper::checkRoute('/booking/validation')): ?>
<div class="col-md-12">
    <?= $form->field($model, 'adult_price')->widget(MaskedInput::className(), [
    'mask'               => '999,999',
    'clientOptions'      => [
    'removeMaskOnSubmit' => true,
    ]
    ]) ?>
</div>
<div class="col-md-12">
    <?= $form->field($model, 'child_price')->widget(MaskedInput::className(), [
    'mask'               => '999,999',
    'clientOptions'      => [
    'removeMaskOnSubmit' => true,
    ]
    ]) ?>
</div>
<?php endif; ?>
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
