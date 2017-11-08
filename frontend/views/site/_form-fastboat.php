<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Url;
use rmrevin\yii\fontawesome\AssetBundle;
?>

<?php
$modelBookForm->arrivalPort = 4;
$modelBookForm->departureDate = date('d-m-Y H:i:s') > date('d-m-Y 16:i:s') ? date('d-m-Y',strtotime('+2 DAYS',strtotime(date('d-m-Y')))) : date('d-m-Y',strtotime('+1 DAYS', strtotime(date('d-m-Y'))));
//$modelBookForm->returnDate = $modelBookForm->departureDate;
$items =['1'=>'One Way','2'=>'Return'];
$modelBookForm->type = 1;

$customScript = <<< SCRIPT
  $(document).ready(function(){
    $("#div-return").css("visibility", "hidden");
  })
SCRIPT;
$this->registerJs($customScript, \yii\web\View::POS_READY);
$layoutMarker =['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-map-marker"></i>']]];
?>
<?php $form = ActiveForm::begin(); ?>
<div class="row col-md-12 col-sm-12 col-xs-12">
    <div class="col-md-3 col-sm-6 col-xs-12">
      <?= $form->field($modelBookForm, 'departurePort',$layoutMarker)->dropDownList($listDept, [
                        'id' => 'drop-dept',
                        'class'=>'input-sm form-control',
                       /* 'onchange'=>'
                            var from = $("#drop-dept").val();
                            $.ajax({
                              url: "'. Url::to("to-port").'",
                              type: "POST",
                              data: {fromv :from},
                              success: function(data){
                                $("#drop-arv").html(data);
                              }
                            });
                            ///alert(from);
                           ',*/
      ]); ?>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
    <?= $form->field($modelBookForm, 'arrivalPort',$layoutMarker)->dropDownList($listDept, ['id' => 'drop-arv','class'=>'input-sm form-control']); ?>
    </div>
    <div class="col-md-1 col-sm-4 col-xs-4">
    <?= $form->field($modelBookForm, 'adults')->dropDownList($adultList, ['id' => 'drop-adult','class'=>'input-sm form-control']); ?>
    </div>
    <div class="col-md-1 col-sm-4 col-xs-4">
    <?= $form->field($modelBookForm, 'childs')->dropDownList($childList, ['id' => 'drop-child','class'=>'input-sm form-control']); ?>
    </div>
    <div class="col-md-1 col-sm-4 col-xs-4">
    <?= $form->field($modelBookForm, 'infants')->dropDownList($childList, ['id' => 'drop-infant','class'=>'input-sm form-control']); ?>
    </div>  

</div>
<div class="col-md-2 col-md-offset-0 col-sm-6 col-sm-offset-4 col-xs-6 col-xs-offset-4">
<?= $form->field($modelBookForm, 'type')->radioList($items, [ 
    'id' => 'form-type',
    'onchange'=>'
    var type = $("#form-type :radio:checked").val();
    if (type == "2") {
      $("#div-return").css("visibility", "visible");
      $("#div-currency").removeClass("col-xs-6");
      $("#div-currency").addClass("col-xs-12");
    }else{
      $("#div-return").css("visibility", "hidden")
      $("#div-currency").removeClass("col-xs-12");
      $("#div-currency").addClass("col-xs-6");
    }',])->label(false); ?>
</div>
					<div class="col-md-2 col-sm-4 col-xs-6">
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
					<div class="col-md-2 col-sm-4 col-xs-6" id="div-return">


					<?= $form->field($modelBookForm, 'returnDate')->widget(kato\pickadate\Pickadate::classname(), [
						'isTime' => false,
						'id'=>'return-date',
						'options'=>['id'=>'return-date','class'=>'input-sm form-control'],

					]); ?>
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

$('.list-currency').on('click',function(){
    var vcurrency = $(this).attr('value').toUpperCase();
    $('#form-currency').val(vcurrency);
    $('#dropdown-text').text(vcurrency);
});
$('#layout-drop-currency').on('show.bs.dropdown',function(){
        $('#search-currency').click();
        $('#search-currency').focus();
});
$('#layout-drop-currency').on('hidden.bs.dropdown',function(){
        $('#search-currency').val(null);
        $('.currency-li').show();
});
  ", \yii\web\View::POS_READY); 
?>
<?php
$modelBookForm->currency = (isset($session['currency'])) ? $session['currency'] : 'USD'; 
 ?>
<?php Pjax::end(); ?> 

<div id="div-currency" class="col-md-2 col-sm-4 col-xs-6">
<?= Html::label('<span class="fa fa-money"></span> Currency', 'currency', ['class' => 'control-label']); ?>
<div id="layout-drop-currency" class="dropdown material-dropdown material-dropdown_primary main-container__column">

    <?= Html::button('<span id="dropdown-text">'.$modelBookForm->currency.'</span><span class="caret material-dropdown__caret "></span>', [
    'class' => 'dropdown-toggle material-dropdown__btn',
    'data-toggle'=>'dropdown',
    'onclick'=>'

      '
    ]); ?>
    <ul id="currency-ul" style="height: 200px; overflow: auto;" class="dropdown-menu material-dropdown-menu material-dropdown-menu_primary">
    <div id="search-form-currency" class="main-container__column">    
        <div class="form-group materail-input-block materail-input-block_warning materail-input_slide-line">
        
    <?= Html::textInput('search-currency', $value = null, [
        'id'=>'search-currency',
        'style'=>'position: sticky;',
        'class' => 'form-control materail-input',
        'placeholder'=>'Search Currency...',
        'onkeyup'=>'
          var input, filter, ul, li, a, i;
    input = document.getElementById("search-currency");
    filter = input.value.toUpperCase();
    ul = document.getElementById("currency-ul");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";

        }
    }
        '
        ]); ?>
          <span class="materail-input-block__line"></span>
        </div>  
    </div>
      <?php foreach($listCurrency as $valCurency): ?>
        <li class="currency-li"><?= Html::a($valCurency, $url = null, ['value' => $valCurency,'class'=>'material-dropdown-menu__link list-currency']); ?></li>
      <?php endforeach; ?>
      
    </ul>
</div>
<?= Html::activeHiddenInput($modelBookForm, 'currency', ['id' => 'form-currency']); ?>
</div>
          <div class="form-group col-md-12 col-sm-12 col-xs-12">
         
          <?= Html::submitButton(Yii::t('app', 'Search'), ['class' =>'btn material-btn material-btn_warning main-container__column material-btn_lg btn-block']) ?>
          </div>     
<?php ActiveForm::end(); ?>
