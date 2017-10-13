<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
$this->title = 'Welcome To GiliTransfers';
?>


<div class="site-wrapper">
  <div class="site-wrapper-inner">
    <div class="cover-container">
      <div class="masthead clearfix">
      <!-- Navbar Start -->
       
        
        <!-- Navbar End -->
      </div>
    </div>

</div>

</div>
    <!--<div style="padding-top: 15%; padding-left: 0px; margin-left: 0px;" class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-book"></span> Book Now</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form">
                    
                    </form>
                </div>
            </div>
        </div>-->
<div class="panel panel-default col-md-5">
                <div class="panel-heading" style="font-weight: bold; font-size: 30px;">BOOK NOW</div>
                <div class="panel-body">
					<?php $form = ActiveForm::begin();
                    $modelBookForm->arrivalPort = 4;
                    $modelBookForm->departureDate = date('d-m-Y H:i:s') < date('d-m-Y 16:i:s') ? date('d-m-Y',strtotime('+2 DAYS',strtotime(date('d-m-Y')))) : date('d-m-Y',strtotime('+1 DAYS', strtotime(date('d-m-Y'))));// date('d-m-Y',strtotime($limitdate));
                    $modelBookForm->returnDate = $modelBookForm->departureDate;
                    $items =['1'=>'One Way','2'=>'Return'];
                    $modelBookForm->type = 1;
                   
                    ?>
                    <div class="col-md-6">
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
                    <div class="col-md-6">
                    <?= $form->field($modelBookForm, 'arrivalPort')->dropDownList($listDept, ['id' => 'drop-arv','class'=>'input-sm form-control']); ?>
                    </div>
                    <div class="col-md-12">
                     <?= $form->field($modelBookForm, 'type')->radioList($items, [
                     		'id' => 'form-type',
                     		'onchange'=>'
                     		var type = $("#form-type :radio:checked").val();
                     		if (type == "2") {
                     			$("#div-return").show(200);
                     		}else{
                     			$("#div-return").hide(200);
                     		}
                     		',
                     		])->label(''); ?>
                    </div>
					<div class="col-md-6">
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
					
					<div style="display: none;" class="col-md-6" id="div-return">
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
					<div class="col-md-12">
                    <div class="col-md-3">
                    <?= $form->field($modelBookForm, 'adults')->dropDownList($adultList, ['id' => 'drop-adult','class'=>'input-sm form-control']); ?>
                    </div>
                    <div class="col-md-3">
                    <?= $form->field($modelBookForm, 'childs')->dropDownList($childList, ['id' => 'drop-child','class'=>'input-sm form-control']); ?>
                    </div>
                    <div class="col-md-3">
                    <?= $form->field($modelBookForm, 'infants')->dropDownList($childList, ['id' => 'drop-infant','class'=>'input-sm form-control']); ?>
					</div>
          <div class="col-md-3">
                    <?= $form->field($modelBookForm, 'currency')->dropDownList($listCurrency, ['id' => 'drop-currency','class'=>'input-sm form-control']); ?>
          
        </div>
					</div>
					<div class="form-group col-md-12">
         
					<?= Html::submitButton(Yii::t('app', 'Next'), ['class' =>'btn material-btn material-btn_warning main-container__column material-btn_lg btn-block']) ?>
					</div>
                    <?php ActiveForm::end(); ?>
                </div>
</div>
<style type="text/css">
	/*

* Based on Cover by https://twitter.com/mdo"  @mdo
* added cover image and background color to match (green)
*
* Globals

*/

/* Links */
a,
a:focus,
a:hover {
  color: #fff;
}

/* Custom default button */
.btn-default,
.btn-default:hover,
.btn-default:focus {
  color: #333;
  text-shadow: none; /* Prevent inheritence from `body` */
  background-color: #fff;
  border: 1px solid #fff;
}


/*
 * Base structure
 */

html,
body {
/*css for full size background image*/
  background: url(/img/patagonia.jpg) no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
  height: 100%;
  background-color: #060;  text-align: center;
 
}

/* Extra markup and styles for table-esque vertical and horizontal centering */
.site-wrapper {
  display: table;
  width: 100%;
  height: 100%; /* For at least Firefox */
  min-height: 100%;
  -webkit-box-shadow: inset 0 0 100px rgba(0,0,0,.5);
          box-shadow: inset 0 0 100px rgba(0,0,0,.5);
}
.site-wrapper-inner {
  display: table-cell;
  vertical-align: top;
}
.cover-container {
  margin-right: auto;
  margin-left: auto;
}

/* Padding for spacing */
.inner {
  padding: 30px;
}


/*
 * Header
 */
.masthead-brand {
  margin-top: 10px;
  margin-bottom: 10px;
}

.masthead-nav > li {
  display: inline-block;
}
.masthead-nav > li + li {
  margin-left: 20px;
}
.masthead-nav > li > a {
  padding-right: 0;
  padding-left: 0;

  border-bottom: 2px solid transparent;
}
.masthead-nav > li > a:hover,
.masthead-nav > li > a:focus {
  background-color: transparent;
  border-bottom-color: #a9a9a9;
  border-bottom-color: rgba(255,255,255,.25);
}
.masthead-nav > .active > a,
.masthead-nav > .active > a:hover,
.masthead-nav > .active > a:focus {
  color: #fff;
  border-bottom-color: #fff;
}

@media (min-width: 768px) {
  .masthead-brand {
    float: left;
  }
  .masthead-nav {
    float: right;
  }
}


/*
 * Cover
 */

.cover {
  padding: 0 20px;
}
.cover .btn-lg {
  padding: 10px 20px;
  font-weight: bold;
}


/*
 * Footer
 */

.mastfoot {
  color: #999; /* IE8 proofing */
  color: rgba(255,255,255,.5);
}


/*
 * Affix and center
 */

@media (min-width: 768px) {
  /* Pull out the header and footer */
  .masthead {
    position: fixed;
    top: 0;
  }
  .mastfoot {
    position: fixed;
    bottom: 0;
  }
  /* Start the vertical centering */
  .site-wrapper-inner {
    vertical-align: middle;
  }
  /* Handle the widths */
  .masthead,
  .mastfoot,
  .cover-container {
    width: 100%; /* Must be percentage or pixels for horizontal alignment */
  }
}

@media (min-width: 992px) {
  .masthead,
  .mastfoot,
  .cover-container {
    width: 700px;
  }
}

</style>
