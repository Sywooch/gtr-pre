<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kato\pickadate\Pickadate;

/* @var $this yii\web\View */
/* @var $model common\models\TTime */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ttime-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'time')->widget(Pickadate::classname(), [
    'isTime' => true,
    'pickadateOptions' => [
        'formatSubmit' => 'H:i',
        'format'=> 'H:i',
        'interval'=>15,
    ],
]); ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
