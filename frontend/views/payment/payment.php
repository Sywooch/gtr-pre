<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\label\LabelInPlace;
use kartik\widgets\FileInput;
$this->title = 'Confirm Payment';
$config = ['template'=>"{input}\n{error}\n{hint}"];

?>
<h1><?= Html::encode($this->title); ?></h1>
<div class="col-md-12">
<div class="panel panel-default material-panel material-panel_primary">
    <h5 class="panel-heading material-panel__heading">Fill The Form To Confirm Your Payment Transfers</h5>
    <div class="panel-body material-panel__body">
    <div class="row">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
  <div class="col-md-8">
    
        <?= $form->field($modelConfirmPayment, "name",$config)->widget(LabelInPlace::classname(),
                [               
                'class'=>'form-control name',
                'defaultIndicators'=>false,
                'encodeLabel'=> false,
                'label'=>'<i class="glyphicon glyphicon-user"></i> Sender Name',
                ]
                );
        ?>
        <?= $form->field($modelConfirmPayment, "amount",$config)->widget(LabelInPlace::classname(),
                [               
                'class'=>'form-control amount',
                'defaultIndicators'=>false,
                'encodeLabel'=> false,
                'label'=>'<i class="glyphicon glyphicon-usd"></i> Send Amount In IDR',
                ]
                );
        ?>

        <?= $form->field($modelConfirmPayment, "note",$config)->widget(LabelInPlace::classname(),
                [         
                'type'              => LabelInPlace::TYPE_TEXTAREA,      
                'class'=>'form-control note',
                'defaultIndicators'=>false,
                'encodeLabel'=> false,
                'label'=>'<i class="glyphicon glyphicon-book"></i> Note (Optional)',
                ]
                );
        ?>
        <a  href="#" title=" " data-toggle="popover" data-trigger="focus hover" data-content="To Help us speeding up the confirmation process"><span class="glyphicon glyphicon-question-sign"></span></a>
        <?= $form->field($modelConfirmPayment, 'imageFiles')->widget(FileInput::classname(), [
        'options' => [
        'id'=>'form-image-proof',
        'multiple'=>false,
        'accept' => 'image/*',
        'resizeImages'=>true,
        ],
        'pluginOptions' => [
            'showRemove' => true,
            'showUpload'=>false,
        ]
        ])->label(false); ?>
</div>
    <div class="form-group col-md-12">
        <?= Html::submitButton('Confirm', ['class' => 'btn material-btn material-btn_warning main-container__column material-btn_lg btn-block btn-block']); ?>
    </div>
<?php ActiveForm::end(); ?>
    
</div>
</div>
</div>

<?php
$this->registerJs('
$(".file-caption-name").attr("placeholder","Upload Payment Slip...(Optional)");
$("[data-toggle=\'popover\']").popover();
    ', \yii\web\View::POS_READY);
?>