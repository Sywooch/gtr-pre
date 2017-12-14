<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\DatePicker;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $modelBooking common\models\TBooking */
/* @var $form yii\widgets\ActiveForm */
$modelBooking->date          = $modelBooking->idTrip->date;
$modelBooking->departurePort = $modelBooking->idTrip->idRoute->departure;
$modelBooking->arrivalPort   = $modelBooking->idTrip->idRoute->arrival;

$layoutMarker =['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-map-marker"></i>']]];
?>

<div class="row">
<div class="col-md-12">
<small>if something goes wrong please repeat the process / contact the developer</small>
<blockquote>
    Current trip : <?=  "<b>".$modelBooking->idTrip->idBoat->idCompany->name."</b>( <span class='text-primary'>".$modelBooking->idTrip->idRoute->departureHarbor->name."</span> -> <span class='text-warning'>".$modelBooking->idTrip->idRoute->arrivalHarbor->name."</span> ) On <b>".date('d-m-Y',strtotime($modelBooking->idTrip->date))."</b> At <b>". date('H:i',strtotime($modelBooking->idTrip->dept_time))."</b>" ?>
</blockquote>
</div>
<?php yii\widgets\Pjax::begin(['id' => 'pjax-form-booking-modify']) ?>
    <?php $form = ActiveForm::begin([
        'options' => ['data-pjax' => true ],
        'action'  => ['booking-modify'],
        'method'  => 'get',]); ?>
<div class="col-md-3">
    <?= $form->field($modelBooking, 'date')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'Enter trip Date'],
    'pickerButton' => false,
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
    ]
    ]); ?>
</div>
    <div class="col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($modelBooking, 'departurePort',$layoutMarker)->dropDownList($listDept,
      ['id' => 'drop-dept']
    ); ?>

    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($modelBooking, 'arrivalPort',$layoutMarker)->dropDownList($listDept,
      ['id' => 'drop-arv']
    ); ?>
    </div>
    <?= Html::activeHiddenInput($modelBooking, 'id', ['readonly' => true]); ?>
     <?= Html::hiddenInput('pax', count($modelBooking->affectedPassengers), ['class' => 'form-control']); ?>

    <div class="form-group col-md-12">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-warning btn-block']) ?>
    <h3 id="loading-pjax-modify">Submit Form To View Result...</h3>
    </div>

    <?php ActiveForm::end(); ?>


<?php yii\widgets\Pjax::end() ?>
</div>
<?php
 
$this->registerJs('
        $.pjax.defaults.timeout = 50000;
        $("#pjax-form-booking-modify").on("pjax:start", function() {
            $("#loading-pjax-modify").html(\'<img src="/spinner.svg">\');
        }); 
        $("#pjax-form-booking-modify").on("pjax:end", function(data) {
            $("#loading-pjax-modify").html(data);
        });
');
?>