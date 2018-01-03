<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TBoat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tboat-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_company')->dropDownList($CompanyList,['prompt' => '-> Boat Company <-']);?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
