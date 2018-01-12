<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TShuttleLocation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tshuttle-location-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_area')->dropDownList($listArea) ?>

    <?= $form->field($model, 'location_name')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true])->label('Optional, Just For information') ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
