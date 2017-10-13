<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TAvaibility */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tavaibility-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_trip')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'stok')->textInput() ?>

    <?= $form->field($model, 'sold')->textInput() ?>

    <?= $form->field($model, 'process')->textInput() ?>

    <?= $form->field($model, 'cancel')->textInput() ?>

    <?= $form->field($model, 'datetime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
