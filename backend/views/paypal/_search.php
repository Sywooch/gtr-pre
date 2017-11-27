<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TPaypalTransactionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tpaypal-transaction-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_payer') ?>

    <?= $form->field($model, 'amount') ?>

    <?= $form->field($model, 'currency') ?>

    <?= $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'id_intent') ?>

    <?php // echo $form->field($model, 'id_status') ?>

    <?php // echo $form->field($model, 'payment_token') ?>

    <?php // echo $form->field($model, 'paypal_time') ?>

    <?php // echo $form->field($model, 'datetime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
