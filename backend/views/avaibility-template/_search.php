<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TAvaibilityTemplateSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tavaibility-template-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_company') ?>

    <?= $form->field($model, 'senin') ?>

    <?= $form->field($model, 'selasa') ?>

    <?= $form->field($model, 'rabu') ?>

    <?php // echo $form->field($model, 'kamis') ?>

    <?php // echo $form->field($model, 'jumat') ?>

    <?php // echo $form->field($model, 'sabtu') ?>

    <?php // echo $form->field($model, 'minggu') ?>

    <?php // echo $form->field($model, 'datetime') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
