<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Url;
?>
<?php $form = ActiveForm::begin();
$modelBookForm->arrivalPort = 4;
$modelBookForm->departureDate = date('d-m-Y H:i:s') < date('d-m-Y 16:i:s') ? date('d-m-Y',strtotime('+2 DAYS',strtotime(date('d-m-Y')))) : date('d-m-Y',strtotime('+1 DAYS', strtotime(date('d-m-Y'))));
$modelBookForm->returnDate = $modelBookForm->departureDate;
$items =['1'=>'One Way','2'=>'Return'];
$modelBookForm->type = 1;
?>
<div class="row col-md-12 col-sm-12 col-xs-12">
    <div class="col-md-2 col-sm-6 col-xs-6">
      <?= $form->field($modelBookForm, 'departurePort')->dropDownList($listDept, [
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
    <div class="col-md-2 col-sm-6 col-xs-6">
    <?= $form->field($modelBookForm, 'arrivalPort')->dropDownList($listDept, ['id' => 'drop-arv','class'=>'input-sm form-control']); ?>
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
                     		}
                     		',
                     		])->label(''); ?>
                    </div>
					<div class="col-md-2 col-sm-4 col-xs-6">
					<?= $form->field($modelBookForm, 'departureDate')->widget(kato\pickadate\Pickadate::classname(), [
						'isTime' => false,
						//'id'=>'dept-date',
						'options'=>[
							'id'=>'dept-date',
							'class'=>'input-sm form-control',
              'onchange'=>'
                $.pjax.reload({
                  container: "#pjax-return",
                });
              ',
              ],
						'pickadateOptions' => [
						'format'=> 'dd-mm-yyyy',
						'formatSubmit'=> 'yyyy-mm-dd',
						'min'=>date('d-m-Y H:i:s') < date('d-m-Y 16:i:s') ? +2 : +1 ,
             'clear'=>'',
             'today'=>'',
						],
            
					]); ?>
					</div>
					
					<div style="visibility: hidden;" class="col-md-2 col-sm-4 col-xs-6" id="div-return">
<?php Pjax::begin(['id'=>'pjax-return']); ?>
<?php
$this->registerJs("
$('#return-date').pickadate({
  min:+2,
  format: 'dd-mm-yyyy',
  formatSubmit: 'yyyy-mm-dd',
  clear:'',
  today:'',
});
  ", \yii\web\View::POS_READY);
$modelBookForm->currency = (isset($session['currency'])) ? $session['currency'] : null;

 ?>

					<?= $form->field($modelBookForm, 'returnDate')->widget(kato\pickadate\Pickadate::classname(), [
						'isTime' => false,
						'id'=>'return-date',
						'options'=>['id'=>'return-date','class'=>'input-sm form-control'],

					]); ?>
<?php Pjax::end(); ?>
					</div>
          <div id="div-currency" class="col-md-1 col-sm-4 col-xs-6">
                    <?= $form->field($modelBookForm, 'currency')->dropDownList($listCurrency, ['id' => 'drop-currency','class'=>'input-sm form-control']); ?>
          
        </div>
					<div class="form-group col-md-12 col-sm-12 col-xs-12">
         
					<?= Html::submitButton(Yii::t('app', 'Search'), ['class' =>'btn material-btn material-btn_warning main-container__column material-btn_lg btn-block']) ?>
					</div>
<?php ActiveForm::end(); ?>
       