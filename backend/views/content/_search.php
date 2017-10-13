<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model common\models\ContentSearch */
/* @var $form yii\widgets\ActiveForm */
$layout = ['template'=>"<div class=\"col-md-2\">{label}\n{input}\n{error}\n{hint}</div>"];
$listType = [
    '1'=>'FastBoat',
    '2'=>'Ports',
    '3'=>'Destination',
    '4'=>'Articles',
    '5'=>'Keyword Puller',
    ]
?>

<div class="tcontent-search col-md-12">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_type_content',$layout)->dropDownList($listType, ['prompt' => 'Select Type...']); ?>

    <?= $form->field($model, 'title',$layout)->widget(Select2::classname(), [
            'data' => ArrayHelper::map($modelContent, 'title', 'title', 'idTypeContent.type'),
            'options' => ['placeholder' => 'Select a Title ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>


    <?= $form->field($model, 'author',$layout)->widget(Select2::classname(), [
            'data' => ArrayHelper::map($modelContent, 'author', 'author0.username'),
            'options' => ['placeholder' => 'Select a Author ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>


    <div class="form-group col-md-12">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
