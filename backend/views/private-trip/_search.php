<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TPrivateTripSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tprivate-trip-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_route') ?>

    <?= $form->field($model, 'min_price') ?>

    <?= $form->field($model, 'max_person') ?>

    <?= $form->field($model, 'person_price') ?>

    <?php // echo $form->field($model, 'min_time') ?>

    <?php // echo $form->field($model, 'max_time') ?>

    <?php // echo $form->field($model, 'datetime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
