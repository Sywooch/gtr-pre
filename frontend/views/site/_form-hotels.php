<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kato\pickadate\Pickadate;
use yii\helpers\Url;
use kartik\widgets\DatePicker;
use kartik\widgets\TouchSpin;
?>
<?php $form = ActiveForm::begin([
		'id'=>'form-hotels',
        'action' => 'https://www.agoda.com/partners/partnersearch.aspx',
        'method' => 'get',
        'options'=>['target'=>'_blank'],
    ]); ?>
<?= Html::hiddenInput('cid', $value = 1605135, ['option' => 'value']); ?>
<?= Html::hiddenInput('pcs', $value = 1, ['option' => 'value']); ?>
<?= Html::hiddenInput('hl', $value = 'en', ['option' => 'value']); ?>
<div class="col-md-12">
<div class="col-md-2">
<label class="control-label" for="city">City</label>
<?= Html::dropDownList('city', '', ['17193'=>'Bali','16842'=>'Lombok','106065'=>'Banyuwangi'], ['class' => 'form-control']); ?>

</div>
<div class="col-md-4">
<?php 
    echo '<label class="control-label">Checkin And Checkout Date</label>';
    echo DatePicker::widget([
        'name' => 'checkin',
        'value' => date('Y-m-d'),
        'type' => DatePicker::TYPE_RANGE,
        'name2' => 'checkOut',
        'value2' => date('Y-m-d',strtotime("+1 DAYS",strtotime(date('Y-m-d')))),
        'pluginOptions' => [
        	'startDate' => date('Y-m-d'),
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);
?>
</div>
</div>
<div class="col-md-12">
    <div class="col-md-2">
    <label class="control-label" for="city">Rooms</label>
    <?php 
    echo TouchSpin::widget([
        'name' => 'rooms',
        'pluginOptions' => [
            'initval' => 1,
            'min' => 1,
            'max' => 5,
            'step' => 1,
            'decimals' => 0,
            'boostat' => 2,
            'maxboostedstep' => 2,
            'buttonup_txt' => '<i class="glyphicon glyphicon-plus-sign"></i>', 
            'buttondown_txt' => '<i class="glyphicon glyphicon-minus-sign"></i>'
        ],
    ]);
    ?>
    </div>
    <div class="col-md-2">
    <label class="control-label" for="city">Adults</label>
    <?php 
    echo TouchSpin::widget([
        'name' => 'adults',
        'pluginOptions' => [
            'initval' => 1,
            'min' => 1,
            'max' => 10,
            'step' => 1,
            'decimals' => 0,
            'boostat' => 2,
            'maxboostedstep' => 2,
            'buttonup_txt' => '<i class="glyphicon glyphicon-plus-sign"></i>', 
            'buttondown_txt' => '<i class="glyphicon glyphicon-minus-sign"></i>'
        ],
    ]);
    ?>
    </div>
    <div class="col-md-2">
    <label class="control-label" for="city">Child</label>
    <?php 
    echo TouchSpin::widget([
        'name' => 'children',
        'pluginOptions' => [
            'initval' => 0,
            'min' => 0,
            'max' => 10,
            'step' => 1,
            'decimals' => 0,
            'boostat' => 2,
            'maxboostedstep' => 2,
            'buttonup_txt' => '<i class="glyphicon glyphicon-plus-sign"></i>', 
            'buttondown_txt' => '<i class="glyphicon glyphicon-minus-sign"></i>'
        ],
    ]);
    ?>
    </div>
</div>

<?= Html::hiddenInput('sort', $value = 'priceLowToHigh', ['option' => 'value']); ?>
<div class="form-group col-md-12 col-sm-12 col-xs-12">
<div class="col-md-6">
<label class="control-label" for="city">&nbsp</label>
<?= Html::submitButton(' Search', ['class' => 'btn material-btn material-btn_warning main-container__column material-btn_lg glyphicon glyphicon-arrow-right btn-block']); ?>
</div>
</div>
<?php ActiveForm::end(); 
?>
