<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\TouchSpin;
$this->title = 'Fast Boat Transfers Bali to Gili Island / Lombok / Nusa Lembongan';

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Fastboat from bali to gili island',
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => 'fastboat, fatboat bali to gili, transfers bali to gili',
]);
 
?>
<?php if($listContent[0]->id_type_content == 9): ?>
<div class="well row col-md-12">
    <h1>Book Your Hotel</h1>
<?php $form = ActiveForm::begin([
        'id'=>'form-hotels',
        'action' => 'https://www.agoda.com/partners/partnersearch.aspx',
        'method' => 'get',
        'options'=>['target'=>'_blank'],
    ]); ?>
<?= Html::hiddenInput('cid', $value = 1605135, ['option' => 'value']); ?>
<?= Html::hiddenInput('pcs', $value = 1, ['option' => 'value']); ?>
<?= Html::hiddenInput('hl', $value = 'en', ['option' => 'value']); ?>
<div class="col-md-2">
<label class="control-label" for="city">Location</label>
<?= Html::dropDownList('city', '', ['17193'=>'Bali','16842'=>'Lombok'], ['class' => 'form-control']); ?>

</div>
<div class="col-md-5">
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

<div class="col-md-2">
    <label>Rooms</label>
    <?= Html::dropDownList('rooms', '1', ['1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10'], ['class' => 'form-control']); ?>
            </div>
<div class="col-md-3">
    <label class="control-label">No Of Pax</label>
      <div id="pax-list" class="dropdown material-dropdown main-container__column">
          <li style="padding: 5px 15px 5px 15px; text-align: center;" class="dropdown-toggle list-group-item" data-toggle="dropdown" class="list-group-item">
           <span class="fa fa-group"></span> Adult <span id="span-hotel-adult">1 </span>, Childs <span id="span-hotels-child"> 0</span>
          </li>
        <div class="dropdown-menu">
        <div class="panel panel-default material-panel material-panel_primary">
          <div class="panel-body material-panel__body">
            <div class="row">
            
            <div class="col-md-12">
                <?php
                echo '<label class="control-label">Adult</label>';
                echo TouchSpin::widget([
                  'name'     => 'adults',
                  'id'            => 'form-hotel-adults',
                  'readonly'      => true,
                  'pluginOptions' => [
                    'buttonup_class'   => 'btn btn-primary', 
                    'buttondown_class' => 'btn btn-primary', 
                    'buttonup_txt'     => '<i class="glyphicon glyphicon-plus-sign"></i>', 
                    'buttondown_txt'   => '<i class="glyphicon glyphicon-minus-sign"></i>',
                    'initval'          => 1,
                    'min'              => 1,
                    'max'              => 10,
                    'step'             => 1,
                    'decimals'         => 0,
                    'boostat'          => 2,
                    'maxboostedstep'   => 2,

                  ],
                  'pluginEvents'=>[
                  "change"=>'function(){
                    $("#span-hotel-adult").text($(this).val());
                  }'
                ]
                ]);?>
              </div>
              <div class="col-md-12">
                <?php
                echo '<label class="control-label">Childs</label>';
                echo TouchSpin::widget([
                  'name'          => 'children',
                  'id'            => 'form-hotels-infats',
                  'readonly'      => true,
                  'pluginOptions' => [
                    'buttonup_class'   => 'btn btn-primary', 
                    'buttondown_class' => 'btn btn-primary', 
                    'buttonup_txt'     => '<i class="glyphicon glyphicon-plus-sign"></i>', 
                    'buttondown_txt'   => '<i class="glyphicon glyphicon-minus-sign"></i>',
                    'initval'          => 0,
                    'min'              => 0,
                    'max'              => 10,
                    'step'             => 1,
                    'decimals'         => 0,
                    'boostat'          => 2,
                    'maxboostedstep'   => 2,
                  ],
                  'pluginEvents'=>[
                  "change"=>'function(){
                    $("#span-hotels-child").text($(this).val());
                  }'
                ]
                ]); 
                ?>
              </div>
            </div>
          </div>
          <div class="panel-footer">
            <?= Html::button('Done', [
                'class' => 'btn material-btn material-btn_warning main-container__column material-btn_sm btn-block',
                'onclick'=>'
                   $(".dropdown").removeClass("open");
                '
                ]); ?>
          </div>
        </div>
        </div>
      </div> 
</div>

<?= Html::hiddenInput('sort', $value = 'priceLowToHigh', ['option' => 'value']); ?>
<div class="form-group col-md-12 col-sm-12 col-xs-12">
<label class="control-label" for="city">&nbsp</label>
<?= Html::submitButton(' Search', ['class' => 'btn material-btn material-btn_warning main-container__column material-btn_lg glyphicon glyphicon-search btn-block']); ?>
</div>
<?php ActiveForm::end(); ?>
</div>
<?php endif; ?>
<?php foreach ($listContent as $keyAr => $valContent): ?>
<div class="col-sm-6 col-md-4 col-xs-12">

    <div class="div-card thumbnail material-card">
        <div class="material-card__header header-card">
        <?= Html::a(Html::img(['thumbnail','slug'=>$valContent->slug], ['class'=>'img','alt'=>'thumbnail'.$valContent->slug]),'/'.strtolower(str_replace([" ","/","&"], "-", $valContent->idTypeContent->type)).'/'.$valContent->slug); ?>
        </div>
    <div class="material-card__content">
        <h2 class="material-card__title"><?= Html::a($valContent->title, ['view','slug'=>$valContent->slug]); ?></h2>
        <p style="text-align: justify;"><?= substr($valContent->description, 0,100) ?></p>
    </div>

     <div class="material-card__footer">
        <?= Html::a('Read more', '/'.strtolower(str_replace([" ","/","&"], "-", $valContent->idTypeContent->type)).'/'.$valContent->slug,['class'=>'btn material-btn material-btn_warning main-container__column material-btn_md btn-block']); ?>
     </div>
    </div>
</div>
<?php endforeach;	?>
<?php
$customCss = <<< SCRIPT
    h2{
        font-size: 20px;
        font-weight: bold;
    }
    .material-card__header {
        text-align: center;
    }
    
    @media (max-width: 990px) {
        .img {
        min-height : 200px;
        max-height : 200px;
        height: auto;
        }
    }

    @media (min-width: 500px) {
        .img {
        width: auto;
        min-height : 200px;
        max-height : 200px;
        height: auto;
        }
    }

    .div-card{
        min-height: 425px;
        height: auto;
    }
    .material-card__content{
        min-height: 140px;
        height: auto;
    }
SCRIPT;
$this->registerCss($customCss);
?>