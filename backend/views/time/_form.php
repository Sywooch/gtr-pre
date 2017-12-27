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
        'formatSubmit' => 'HH:i',
        'format'=> 'HH:i',
        'interval'=>15,
    ],
]); ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success' ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
