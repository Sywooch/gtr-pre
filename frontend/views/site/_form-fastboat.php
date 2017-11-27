<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\widgets\Pjax;
use kartik\widgets\Select2;
use yii\helpers\Url;
use kartik\widgets\TouchSpin;
?>

<?php
$modelBookForm->arrivalPort = 4;
$modelBookForm->departureDate = date('d-m-Y H:i:s') > date('d-m-Y 16:i:s') ? date('d-m-Y',strtotime('+2 DAYS',strtotime(date('d-m-Y')))) : date('d-m-Y',strtotime('+1 DAYS', strtotime(date('d-m-Y'))));
//$modelBookForm->returnDate = $modelBookForm->departureDate;
$items =['1'=>'One Way','2'=>'Return'];
//$modelBookForm->type = 1;

$customScript = <<< SCRIPT
  $(document).ready(function(){
    $("#div-return").css("visibility", "hidden");
  })
SCRIPT;
$this->registerJs($customScript, \yii\web\View::POS_READY);
$layoutMarker =['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-map-marker"></i>']]];
?>
<?php $form = ActiveForm::begin(); ?>
<!--<div class="row col-md-12 col-sm-12 col-xs-12">-->
    <div class="col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($modelBookForm, 'departurePort',$layoutMarker)->dropDownList($listDept,
      ['id' => 'drop-dept']
    ); ?>

    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($modelBookForm, 'arrivalPort',$layoutMarker)->dropDownList($listDept,
      ['id' => 'drop-arv']
    ); ?>
    </div>

    <div style="margin-bottom: 20px;" class="col-md-4 col-sm-12 col-xs-12">
    <label class="control-label">No Of Passengers</label>
      <div id="pax-list" class="dropdown material-dropdown main-container__column">
          <li style="padding: 5px 15px 5px 15px; text-align: center;" class="dropdown-toggle list-group-item" data-toggle="dropdown" class="list-group-item">
           <span class="fa fa-group"></span> Adult <span id="span-adult">1 </span>, Childs <span id="span-child"> 0</span>, Infants <span id="span-infants"> 0</span>
          </li>
        <div class="dropdown-menu">
        <div class="panel panel-default material-panel material-panel_primary">
          <div class="panel-body material-panel__body">
            <div class="row">
            <div class="col-md-12">
              <?php 

              echo '<label class="control-label">Adults <span class="text-muted">(12+ years)</span></label>';
              echo TouchSpin::widget([
                'model'         => $modelBookForm,
                'attribute'     => 'adults',
                'id'            => 'form-adults',
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
                    $("#span-adult").text($(this).val());
                  }'
                ]
              ]);?>
            </div>
            <div class="col-md-12">
                <?php
                echo '<label class="control-label">Childs <span class="text-muted">(2-12 years)</span></label>';
                echo TouchSpin::widget([
                  'model'         => $modelBookForm,
                  'attribute'     => 'childs',
                  'id'            => 'form-childs',
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
                    $("#span-child").text($(this).val());
                  }'
                ]
                ]);?>
              </div>
              
              <div class="col-md-12">
              <label class="control-label">Infants <a data-placement="left" data-popover-content="#a1" data-toggle="popover" data-trigger="focus hover" href="#" tabindex="0"><span class="text-muted"> (0-2) Years Without Seat</span> <span class="fa fa-question-circle"></span></a></label>
                <?php
                // echo '';
                echo TouchSpin::widget([
                  'model'         => $modelBookForm,
                  'attribute'     => 'infants',
                  'id'            => 'form-infats',
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
                    $("#span-infants").text($(this).val());
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
					<?= $form->field($modelBookForm, 'departureDate')->widget(kato\pickadate\Pickadate::classname(), [
						'isTime' => false,
						//'id'=>'dept-date',
						'options'=>[
							'id'=>'dept-date',
							'class'=>'input-sm form-control',
              ],
            
					]); ?>
					</div>
<?php Pjax::begin(['id'=>'pjax-return-date']); ?>					
					<div class="col-md-4 col-sm-4 col-xs-6">
            <div class="main-container__column material-checkbox-group material-checkbox-group_primary">
        <?= Html::activeCheckbox($modelBookForm,'type', [ 
                  'label'=>false,
                  'class' => 'material-checkbox',
                  'id'=>'checkbox-type',
                  'onchange'=>'
                  if ($(this).is(":checked")) {
                    $("#div-return").css("visibility", "visible");
                  }else{
                    $("#div-return").css("visibility", "hidden");

                  }
                  '
                  ]); ?>
        <label class="material-checkbox-group__label" for="checkbox-type"> Return</label>
        </div>
          <div id="div-return">
					<?= $form->field($modelBookForm, 'returnDate')->widget(kato\pickadate\Pickadate::classname(), [
						'isTime' => false,
						'id'=>'return-date',
						'options'=>['id'=>'return-date','class'=>'input-sm form-control'],

					])->label(false); ?>
          </div>
					</div>
<?php 
$this->registerJs("
  $('#dept-date').on('change',function(){
    $('#return-date').val(null);
    /*$.pjax.reload({
                container:'#pjax-return-date',
                complete:typetrip(),
                
              });*/
});
function typetrip(){
                $(\"#div-return\").css(\"visibility\", \"visible\");
};

$('#dept-date').pickadate({
  min: +1,
  format: 'dd-mm-yyyy',
  formatSubmit: 'yyyy-mm-dd',
  clear:'',
  today:'',
});

$('#return-date').pickadate({
  format: 'dd-mm-yyyy',
  formatSubmit: 'yyyy-mm-dd',
  clear:'',
  today:'',
});

var from_input = $('#dept-date').pickadate(),
    from_picker = from_input.pickadate('picker')

var to_input = $('#return-date').pickadate(),
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
$('#pax-list .dropdown-menu').on({
    \"click\":function(e){
      e.stopPropagation();
    }
});
  ", \yii\web\View::POS_READY); 
?>
<?php
$modelBookForm->currency = (isset($session['currency'])) ? $session['currency'] : 'USD'; 
 ?>
<?php Pjax::end(); ?> 

<div id="div-currency" class="col-md-4 col-sm-4 col-xs-12">
<?= $form->field($modelBookForm, 'currency',['addon' => ['prepend' => ['content'=>'<i class="fa fa-money"></i>']]])->widget(Select2::classname(), [
    'data' => $listCurrency,
    'size' => Select2::SMALL,
    'options' => ['placeholder' => 'Select Currency'],
    'pluginOptions' => [
        'allowClear' => false,
    ],
]); ?>
</div>
          <div class="form-group col-md-12 col-sm-12 col-xs-12">
         
          <?= Html::submitButton(Yii::t('app', ' Search'), ['class' =>'btn material-btn material-btn_warning main-container__column material-btn_lg btn-block glyphicon glyphicon-search']) ?>
          </div>     
<?php ActiveForm::end(); ?>

<?php
$customCss = <<< SCRIPT
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

<div class="hidden" id="a1">
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