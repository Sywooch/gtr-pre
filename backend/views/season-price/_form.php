<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\TSeasonPrice */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="tseason-price-form col-md-4">

    <?php $form = ActiveForm::begin(['enableClientValidation'=>false,]); ?>

    <?= $form->field($model, 'id_trip')->widget(Select2::classname(), [
    'data' => $listTrip,
    'options' => ['placeholder' => 'Select Trip ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]) ?>

    <?= $form->field($model, 'id_season_type')->dropDownList($typeSeason, ['id' => 'drop-type-season','prompt'=>'-> Select Season <-']); ?>

    <?= $form->field($model, 'adult_price')->widget(MaskedInput::className(), [
    'mask'               => '999,999',
    'clientOptions'      => [
    'removeMaskOnSubmit' => true,
    ]
    ]) ?>


    <?= $form->field($model, 'child_price')->widget(MaskedInput::className(), [
    'mask'               => '999,999',
    'clientOptions'      => [
    'removeMaskOnSubmit' => true,
    ]
    ]) ?>

    <?= $form->field($model, 'infant_price')->widget(MaskedInput::className(), [
    'mask'               => '999,999',
    'clientOptions'      => [
    'removeMaskOnSubmit' => true,
    ]
    ]) ?>

    <?= $form->field($model, 'start_date')->textInput() ?>

    <?= $form->field($model, 'end_date')->textInput() ?>

    <?= $form->field($model, 'datetime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
