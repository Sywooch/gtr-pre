<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\widgets\TouchSpin;
use kartik\widgets\Select2;
//use rmrevin\yii\fontawesome\AssetBundle;
?>
<?php
$modelPrivateTransfers->arrivalLocation   = 19;
$modelPrivateTransfers->departureLocation = 13;
$modelPrivateTransfers->type        = 0; 
$modelPrivateTransfers->returnDate  = null;
//if (date('d-m-Y H:i:s') >= date('d-m-Y 18:i:s')) {
$modelPrivateTransfers->departureDate = date('d-m-Y',strtotime('+1 DAYS', strtotime(date('d-m-Y'))));
//   $addDay = 1;
// }else{
//   $modelPrivateTransfers->departureDate = date('d-m-Y',strtotime('+1 DAYS',strtotime(date('d-m-Y'))));
//   $addDay = 2;
// }

//$modelPrivateTransfers->returnDate = $modelPrivateTransfers->departureDate;
$items =['1'=>'One Way','2'=>'Return'];
//$modelPrivateTransfers->type = 1;

$customScript = <<< SCRIPT
  $(document).ready(function(){
    $("#div-return-private").css("visibility", "hidden");
  })
SCRIPT;
$this->registerJs($customScript, \yii\web\View::POS_READY);
$layoutMarker =['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-map-marker"></i>']]];
?>
<?php $form = ActiveForm::begin([
        'id'                   => 'form-private-transfers',
        'action'               => '/site/book-private',
        'method'               => 'post',
        ]); ?>
<!--<div class="row col-md-12 col-sm-12 col-xs-12">-->
    <div class="col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($modelPrivateTransfers, 'departureLocation',$layoutMarker)->dropDownList($listLocation,
      ['id' => 'drop-dept-private']
    ); ?>

    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($modelPrivateTransfers, 'arrivalLocation',$layoutMarker)->dropDownList($listLocation,
      ['id' => 'drop-arv-private']
    ); ?>
    </div>

    <div style="margin-bottom: 20px;" class="col-md-4 col-sm-12 col-xs-12">
    <label class="control-label">No of Passengers</label>
      <div id="pax-list" class="dropdown material-dropdown main-container__column">
          <li style="padding: 5px 15px 5px 15px; text-align: center;" class="dropdown-toggle list-group-item" data-toggle="dropdown" class="list-group-item">
           <span class="glyphicon glyphicon-user"></span> Adult <span id="span-adult-private">1 </span>, Child <span id="span-child-private"> 0</span>, Infant <span id="span-infants-private"> 0</span>
          </li>
        <div class="dropdown-menu">
        <div class="panel panel-default material-panel material-panel_primary">
          <div class="panel-body material-panel__body">
            <div class="row">
            <div class="col-md-12">
              <?php 

              echo '<label class="control-label">Adult <span class="text-muted">(12+ years)</span></label>';
              echo TouchSpin::widget([
                'model'         => $modelPrivateTransfers,
                'attribute'     => 'adults',
                'id'            => 'form-adults-private',
                'readonly'      => true,
                'pluginOptions' => [
                  'buttonup_class'   => 'btn btn-primary', 
                  'buttondown_class' => 'btn btn-primary', 
                  'buttonup_txt'     => '<i class="glyphicon glyphicon-plus-sign"></i>', 
                  'buttondown_txt'   => '<i class="glyphicon glyphicon-minus-sign"></i>',
                  'initval'          => 1,
                  'min'              => 1,
                  'max'              => 9,
                  'step'             => 1,
                  'decimals'         => 0,
                  'boostat'          => 2,
                  'maxboostedstep'   => 5,

                ],
                'pluginEvents'=>[
                  "change"=>'function(){
                    $("#span-adult-private").text($(this).val());
                  }'
                ]
              ]);?>
            </div>
            <div class="col-md-12">
                <?php
                echo '<label class="control-label">Child <span class="text-muted">(2-12 years)</span></label>';
                echo TouchSpin::widget([
                  'model'         => $modelPrivateTransfers,
                  'attribute'     => 'childs',
                  'id'            => 'form-childs-private',
                  'readonly'      => true,
                  'pluginOptions' => [
                    'buttonup_class'   => 'btn btn-primary', 
                    'buttondown_class' => 'btn btn-primary', 
                    'buttonup_txt'     => '<i class="glyphicon glyphicon-plus-sign"></i>', 
                    'buttondown_txt'   => '<i class="glyphicon glyphicon-minus-sign"></i>',
                    'initval'          => 0,
                    'min'              => 0,
                    'max'              => 5,
                    'step'             => 1,
                    'decimals'         => 0,
                    'boostat'          => 2,
                    'maxboostedstep'   => 3,

                  ],
                  'pluginEvents'=>[
                  "change"=>'function(){
                    $("#span-child-private").text($(this).val());
                  }'
                ]
                ]);?>
              </div>
              
              <div class="col-md-12">
              <label class="control-label">Infant <a data-placement="left" data-popover-content="#private-popover" data-toggle="popover" data-trigger="focus hover" href="#" tabindex="0"><span class="text-muted"> (0-2) Years Without Seat</span> <span class="fa fa-question-circle"></span></a></label>
                <?php
                // echo '';
                echo TouchSpin::widget([
                  'model'         => $modelPrivateTransfers,
                  'attribute'     => 'infants',
                  'id'            => 'form-infats-private',
                  'readonly'      => true,
                  'pluginOptions' => [
                    'buttonup_class'   => 'btn btn-primary', 
                    'buttondown_class' => 'btn btn-primary', 
                    'buttonup_txt'     => '<i class="glyphicon glyphicon-plus-sign"></i>', 
                    'buttondown_txt'   => '<i class="glyphicon glyphicon-minus-sign"></i>',
                    'initval'          => 0,
                    'min'              => 0,
                    'max'              => 5,
                    'step'             => 1,
                    'decimals'         => 0,
                    'boostat'          => 2,
                    'maxboostedstep'   => 3,
                  ],
                  'pluginEvents'=>[
                  "change"=>'function(){
                    $("#span-infants-private").text($(this).val());
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
<!--</div>-->

          <div class="col-md-4 col-sm-4 col-xs-6">
          <?= $form->field($modelPrivateTransfers, 'departureDate')->widget(kato\pickadate\Pickadate::classname(), [
            'isTime' => false,
            //'id'=>'dept-date-private',
            'options'=>[
              'id'=>'dept-date-private',
              'class'=>'input-sm form-control',
              ],
            
          ])->label('Departure date'); ?>
          <?= $form->field($modelPrivateTransfers, 'departtureTime')->widget(kato\pickadate\Pickadate::classname(), [
            'isTime' => true,
            //'id'=>'dept-date-private',
            'options'=>[
              'id'=>'dept-time-private',
              'class'=>'input-sm form-control',
              ],
            'pickadateOptions' => [
            'formatSubmit' => 'HH:i',
            'min'=>[7,30],
            'max'=>[20,00],
            ],
            
          ])->label('Preferede Departure Time'); ?>
          </div>
<?php Pjax::begin(['id'=>'pjax-return-date-private']); ?>         
          <div class="col-md-4 col-sm-4 col-xs-6">
            <div class="main-container__column material-checkbox-group material-checkbox-group_primary">
        <?= Html::activeCheckbox($modelPrivateTransfers,'type', [ 
                  'label'    => false,
                  'class'    => 'material-checkbox',
                  'id'       => 'checkbox-type-private',
                  'onchange' => '
                  if ($(this).is(":checked")) {
                    $("#div-return-private").css("visibility", "visible");
                  }else{
                    $("#div-return-private").css("visibility", "hidden");

                  }
                  '
                  ]); ?>
        <label class="material-checkbox-group__label" for="checkbox-type-private"> Return</label>
        </div>
          <div id="div-return-private">
          <?= $form->field($modelPrivateTransfers, 'returnDate')->widget(kato\pickadate\Pickadate::classname(), [
            'isTime' => false,
            'id'=>'return-date-private',
            'options'=>['id'=>'return-date-private','class'=>'input-sm form-control'],

          ])->label(false); ?>
          <?= $form->field($modelPrivateTransfers, 'returnTime')->widget(kato\pickadate\Pickadate::classname(), [
            'isTime' => true,
            //'id'=>'dept-date-private',
            'options'=>[
              'id'=>'return-time-private',
              'class'=>'input-sm form-control',
              ],
            'pickadateOptions' => [
            'formatSubmit' => 'HH:i',
            'min'=>[7,30],
            'max'=>[20,00],
            ],
            
          ])->label('Preferede Return Time'); ?>
          </div>
          </div>
<?php 

$this->registerJs("
    $('#dept-date-private').pickadate({
  min: +1,
  format: 'dd-mm-yyyy',
  formatSubmit: 'yyyy-mm-dd',
  clear:'',
  today:'',
});

$('#return-date-private').pickadate({
  format: 'dd-mm-yyyy',
  formatSubmit: 'yyyy-mm-dd',
  clear:'',
  today:'',
});

var from_input = $('#dept-date-private').pickadate(),
    from_picker = from_input.pickadate('picker')

var to_input = $('#return-date-private').pickadate(),
    to_picker = to_input.pickadate('picker')


// Check if there’s a “from” or “to” date to start with.
if ( from_picker.get('value') ) {
  to_picker.set('min', from_picker.get('select'))
}


// When something is selected, update the “from” and “to” limits.
from_picker.on('set', function(event) {
  if ( event.select ) {
    to_picker.set('min', from_picker.get('select'))    
  }
  else if ( 'clear' in event ) {
    to_picker.set('min', false)
  }
});
    ", \yii\web\View::POS_READY);
$this->registerJs("
  $('#dept-date-private').on('change',function(){
    $('#return-date-private').val(null);
    /*$.pjax.reload({
                container:'#pjax-return-date-private',
                complete:typetrip(),
                
              });*/
});
function typetrip(){
                $(\"#div-return-private\").css(\"visibility\", \"visible\");
};

$('#pax-list .dropdown-menu').on({
    \"click\":function(e){
      e.stopPropagation();
    }
});
  ", \yii\web\View::POS_READY); 
?>
<?php
$modelPrivateTransfers->currency = (isset($session['formData']['currency'])) ? $session['formData']['currency'] : 'USD'; 
 ?>
<?php Pjax::end(); ?> 

<div id="div-currency-private" class="col-md-4 col-sm-4 col-xs-12">
<?= $form->field($modelPrivateTransfers, 'currency',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-usd"></i>']]])->widget(Select2::classname(), [
    'data' => $listCurrency,
    'size' => Select2::SMALL,
    'options' => ['placeholder' => 'Select Currency'],
    'pluginOptions' => [
        'allowClear' => false,
    ],
])->label('Currency *'); ?><br>
<?= Html::submitButton(Yii::t('app', ' Search'), ['class' =>'btn material-btn material-btn_warning main-container__column material-btn_lg btn-block glyphicon glyphicon-search']) ?>
</div>

          <div class="col-md-12 col-sm-12 col-xs-12">
         
          
<br>
<span class="text-muted pull-left currency-note">
* Available currencies depend on selected payment method
</span>
<!--   <br>
<span class="text-muted pull-left currency-note">
** Pick Up will Not Available if you book after 6.00 p.m applied for next day trip. We suggest you to arrange your own accomodation to the port.
</span> -->
          </div>     
<?php ActiveForm::end(); ?>

<?php
$customCss = <<< SCRIPT
.currency-note{
  text-align: right;
  font-size: 9px;
}
.text-muted{
  font-size: 10px;
}
.material-checkbox-group__label {
    position: relative;
    display: block;
    cursor: pointer;
    height: 20px;
    line-height: 20px;
    padding-left: 30px;
}
.material-checkbox-group__label::after {
    content: "";
    display: block;
    width: 5px;
    height: 10px;
    opacity: .9;
    border-right: 2px solid #eee;
    border-top: 2px solid #eee;
    position: absolute;
    left: 5px;
    top: 10px;
    -webkit-transform: scaleX(-1) rotate(135deg);
    transform: scaleX(-1) rotate(135deg);
    -webkit-transform-origin: left top;
    transform-origin: left top;
}
.material-checkbox-group__label::before {
    content: "";
    display: block;
    border: 2px solid;
    width: 20px;
    height: 20px;
    position: absolute;
    left: 0;
}
p{
  text-align: justify;
}
SCRIPT;
$this->registerCss($customCss);
 ?>

<div class="hidden" id="private-popover">
  <div class="popover-heading">
    Info
  </div>

  <div class="popover-body">
   <p>If the infant 0-2 years old choose to sit personally please include into child passenger calculations because they are charged</p>
  </div>
</div>
<?php
$this->registerJs('
$(function(){
    $("[data-toggle=popover]").popover({
        html : true,
        content: function() {
          var content = $(this).attr("data-popover-content");
          return $(content).children(".popover-body").html();
        },
        title: function() {
          var title = $(this).attr("data-popover-content");
          return $(title).children(".popover-heading").html();
        }
    });
});');
 ?>