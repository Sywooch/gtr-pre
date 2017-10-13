<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use kartik\label\LabelInPlace;
$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
$layout = ['template'=>"{input}\n{error}\n{hint}"];
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.
    </p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                <?= $form->field($model, 'name', $layout)->widget(LabelInPlace::classname(),[
                'options'=>['autofocus' => true],
                'defaultIndicators'=>false,
                    'encodeLabel'=> false,
                    'label'=>'<i class="glyphicon glyphicon-user"></i> Name',
                ]) ?>

                <?= $form->field($model, 'email', $layout)->widget(LabelInPlace::classname(),[
                'options'=>['autofocus' => true],
                'defaultIndicators'=>false,
                    'encodeLabel'=> false,
                    'label'=>'<i class="glyphicon glyphicon-envelope"></i> Email',
                ]) ?>

                <?= $form->field($model, 'subject', $layout)->widget(LabelInPlace::classname(),[
                'options'=>['autofocus' => true],
                'defaultIndicators'=>false,
                    'encodeLabel'=> false,
                    'label'=>'<i class="glyphicon glyphicon-check"></i> Subject',
                ]) ?>

                <?= $form->field($model, 'body', $layout)->widget(LabelInPlace::classname(),[
                    'type'              => LabelInPlace::TYPE_TEXTAREA,
                    'options'           =>['autofocus' => true],
                    'defaultIndicators' =>false,
                    'encodeLabel'       => false,
                    'label'             =>'<i class="glyphicon glyphicon-book"></i> Body Email',
                ]) ?>

                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                ]) ?>

                <div class="form-group">
                    <?= Html::submitButton(' Send', ['class' => 'btn material-btn material-btn_warning main-container__column material-btn_lg glyphicon glyphicon-send', 'name' => 'contact-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
