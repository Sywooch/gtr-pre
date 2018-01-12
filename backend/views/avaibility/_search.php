<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TAvaibilitySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tavaibility-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_trip') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'stok') ?>

    <?= $form->field($model, 'sold') ?>

    <?php // echo $form->field($model, 'process') ?>

    <?php // echo $form->field($model, 'cancel') ?>

    <?php // echo $form->field($model, 'datetime') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
