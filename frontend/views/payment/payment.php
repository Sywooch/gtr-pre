<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\label\LabelInPlace;
$this->title = 'Confirm Payment';
$config = ['template'=>"{input}\n{error}\n{hint}"];

?>

<?php $form = ActiveForm::begin(); ?>
<div class="col-md-12">
  <div class="col-md-5">
    <h4><?= Html::encode($this->title); ?></h4>
    	<?= $form->field($modelPayment, "send_amount",$config)->widget(LabelInPlace::classname(),
                [               
                'class'=>'form-control amount',
                'defaultIndicators'=>false,
                'encodeLabel'=> false,
                'label'=>'<i class="glyphicon glyphicon-usd"></i> Send Amount',
                ]
                );
        ?>
    </div>
</div>
<div class="col-md-12">
    <div class="form-group col-md-5">
    	<?= Html::submitButton('Next', ['class' => 'btn material-btn material-btn_warning main-container__column material-btn_lg btn-block btn-block']); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>