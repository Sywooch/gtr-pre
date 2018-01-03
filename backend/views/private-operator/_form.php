<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;
/* @var $this yii\web\View */
/* @var $model backend\models\TPrivateOperator */
/* @var $form yii\widgets\ActiveForm */
$model->isNewRecord ? $model->id_status = 1 : null ;
?>

<div class="tprivate-operator-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'placeholder'=>'Operator Name']) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_status')->widget(SwitchInput::classname(), [
                    'type' => SwitchInput::CHECKBOX,
                    'options'=>['uncheck' => 2,'value'=>1,]
                    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
