<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use kato\pickadate\Pickadate;
/* @var $this yii\web\View */
/* @var $model common\models\TPrivateTrip */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="tprivate-trip-form">

    <?php $form = ActiveForm::begin(['enableClientValidation'=>false]); ?>

    <?= $form->field($model, 'id_route')->dropDownList($listRoute, [
        'id' => 'drop-route',
        'prompt'=>'Select Route',
        ]); ?>

    <?= $form->field($model, 'min_price')->widget(MaskedInput::className(), [
    'mask'               => ['999,999'],
    'clientOptions'      => [
    'removeMaskOnSubmit' => true,
    ]
    ]) ?>

    <?= $form->field($model, 'max_person')->textInput() ?>
    <?= $form->field($model, 'person_price')->widget(MaskedInput::className(), [
    'mask'               => ['999,999'],
    'clientOptions'      => [
    'removeMaskOnSubmit' => true, 
    ]
    ]) ?>

    <?= $form->field($model, 'min_time')->widget(Pickadate::classname(), [
    'isTime' => true,
    'pickadateOptions' => [
        'formatSubmit' => 'H:i',
        'format'=> 'H:i',
        'interval'=>15,
    ],
    ]); ?>

    <?= $form->field($model, 'max_time')->widget(Pickadate::classname(), [
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
