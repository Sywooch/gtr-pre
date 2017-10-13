<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $model common\models\TAvaibilityTemplate */
/* @var $form yii\widgets\ActiveForm */
$model->isNewRecord ? $display = "hidden=''" : $display = "style=''";
?>

<div class="tavaibility-template-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_company')->dropDownList($listCompany, ['prompt' => '-> Select Company <-']); ?>
     <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<div class="col-md-12">
<div class="col-md-1">
    <?= $form->field($model, 'senin')->widget(SwitchInput::classname(), ['type' => SwitchInput::CHECKBOX,'pluginOptions' => ['size' => 'mini'],
        'options'=>[
        'uncheck' =>null,
        'value'=>1,
        'onchange'=>'
            if ($(this).is(":checked")) {
            $("#div-time-senin").show(500);
            }else{
            $("#div-time-senin").hide(500);
            $("#field-time-senin").val(null);
            }']]); ?>
</div>
    <div <?= $display ?> id="div-time-senin" class="field-time col-md-11">
    <?= $form->field($model, 'time_senin')->textInput(['id' => 'field-time-senin']); ?>
    </div>
</div>
<div class="col-md-12">
<div class="col-md-1">
    <?= $form->field($model, 'selasa')->widget(SwitchInput::classname(), ['type' => SwitchInput::CHECKBOX,'pluginOptions' => ['size' => 'mini'],
        'options'=>[
            'uncheck' =>null,
            'value'=>2,
            'onchange'=>'
            if ($(this).is(":checked")) {
            $("#div-time-selasa").show(500);
            }else{
            $("#div-time-selasa").hide(500);
            $("#field-time-selasa").val(null);
            }']]); ?>
</div>
    <div <?= $display ?> id="div-time-selasa" class="field-time col-md-11">
    <?= $form->field($model, 'time_selasa')->textInput(['id' => 'field-time-selasa']); ?>
    </div>
</div>
<div class="col-md-12">
<div class="col-md-1">
    <?= $form->field($model, 'rabu')->widget(SwitchInput::classname(), ['type' => SwitchInput::CHECKBOX,'pluginOptions' => ['size' => 'mini'],
        'options'=>[
            'uncheck' =>null,
            'value'=>3,
            'onchange'=>'
            if ($(this).is(":checked")) {
            $("#div-time-rabu").show(500);
            }else{
            $("#div-time-rabu").hide(500);
            $("#field-time-rabu").val(null);
            }']]); ?>
</div>
    <div <?= $display ?> id="div-time-rabu" class="field-time col-md-11">
    <?= $form->field($model, 'time_rabu')->textInput(['id' => 'field-time-rabu']); ?>
    </div>
</div>
<div class="col-md-12">
<div class="col-md-1">
    <?= $form->field($model, 'kamis')->widget(SwitchInput::classname(), ['type' => SwitchInput::CHECKBOX,'pluginOptions' => ['size' => 'mini'],
        'options'=>[
            'uncheck' =>null,
            'value'   =>4,
            'onchange'=>'
            if ($(this).is(":checked")) {
            $("#div-time-kamis").show(500);
            }else{
            $("#div-time-kamis").hide(500);
            $("#field-time-kamis").val(null);
            }']]); ?>
</div>
    <div <?= $display ?> id="div-time-kamis" class="field-time col-md-11">
    <?= $form->field($model, 'time_kamis')->textInput(['id' => 'field-time-kamis']); ?>
    </div>
</div>
<div class="col-md-12">
<div class="col-md-1">
    <?= $form->field($model, 'jumat')->widget(SwitchInput::classname(), ['type' => SwitchInput::CHECKBOX,'pluginOptions' => ['size' => 'mini'],
        'options'=>[
        'uncheck'  =>null,
        'value'    =>5,
        'onchange' =>'
            if ($(this).is(":checked")) {
            $("#div-time-jumat").show(500);
            }else{
            $("#div-time-jumat").hide(500);
            $("#field-time-jumat").val(null);
            }']]); ?>
</div>
    <div <?= $display ?> id="div-time-jumat" class="field-time col-md-11">
    <?= $form->field($model, 'time_jumat')->textInput(['id' => 'field-time-jumat']); ?>
    </div>
</div>
<div class="col-md-12">
<div class="col-md-1">
    <?= $form->field($model, 'sabtu')->widget(SwitchInput::classname(), ['type' => SwitchInput::CHECKBOX,'pluginOptions' => ['size' => 'mini'],
        'options'=>[
            'uncheck' => null,
            'value'   => 6,
            'onchange'=>'
            if ($(this).is(":checked")) {
            $("#div-time-sabtu").show(500);
            }else{
            $("#div-time-sabtu").hide(500);
            $("#field-time-sabtu").val(null);
            }']]); ?>
</div>
    <div <?= $display ?> id="div-time-sabtu" class="field-time col-md-11">
    <?= $form->field($model, 'time_sabtu')->textInput(['id' => 'field-time-sabtu']); ?>
    </div>
</div>
<div class="col-md-12">
<div class="col-md-1">
    <?= $form->field($model, 'minggu')->widget(SwitchInput::classname(), ['type' => SwitchInput::CHECKBOX,'pluginOptions' => ['size' => 'mini'],
        'options'=>[
            'uncheck' => null,
            'value'   => 0,
            'onchange'=>'
            if ($(this).is(":checked")) {
            $("#div-time-minggu").show(500);
            }else{
            $("#div-time-minggu").hide(500);
            $("#field-time-minggu").val(null);
            }']]); ?>
</div>
    <div <?= $display ?> id="div-time-minggu" class="field-time col-md-11">
    <?= $form->field($model, 'time_minggu')->textInput(['id' => 'field-time-minggu']); ?>
    </div>
</div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
