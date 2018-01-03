<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TShuttlePrice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tshuttle-price-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_company')->textInput() ?>

    <?= $form->field($model, 'id_lokasi')->textInput() ?>

    <?= $form->field($model, 'id_shuttle_type')->textInput() ?>

    <?= $form->field($model, 'price_sharing')->textInput() ?>

    <?= $form->field($model, 'price_car')->textInput() ?>

    <?= $form->field($model, 'price_elf')->textInput() ?>

    <?= $form->field($model, 'pickup_time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'datetime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
