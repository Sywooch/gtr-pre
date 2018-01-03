<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\Url;
use kartik\widgets\AlertBlock;

/* @var $this yii\web\View */
/* @var $modelPayment app\models\TPembayaran */
/* @var $form yii\widgets\ActiveForm */
$modelPayment->id_payment_method = 1;
?>
<?php
$customCss = <<< SCRIPT
  .payment-harga{
    font-size: 20px;
    font-weight: bold;
  }
SCRIPT;
$this->registerCss($customCss);

$customScript = <<< SCRIPT
  
SCRIPT;
$this->registerJs('
$(document).ready(function(){
    $("#page-loading").hide(300);
    $("#page-loading").html("");
    $("#form-payment").show(200);

            var metod = $("#rad-method :radio:checked").val();
          if (metod == "") {
            $("#hasil-ajax").fadeOut(200);
            $("#hasil-ajax").html("");
            $("#div-submit").hide(300);


          }
          if (metod == 2) {
            $("#hasil-ajax").fadeOut(200);
            $("#hasil-ajax").html("");
            $("#div-submit").show(300);
            $("#harga-ext").hide(300);
            $("#harga-idr").show(300);
          }

          if (metod == 1) {
            $("#div-submit").hide(300);
            $("#harga-idr").hide(300);
            $("#harga-ext").show(300);
            $("#hasil-ajax").fadeIn(200);
            $.ajax({
                     url : "'.Url::to(["paypal"]).'",
                     type: "POST",
                     success: function (div) {
                     $("#hasil-ajax").html(div);

                     },
                   });
          }
});
  ', \yii\web\View::POS_READY);
?>


<center id="page-loading"><img src=/loading.svg></center>
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>


<div id="form-payment" style="display: none;" class="tpembayaran-form">
    <?php $form = ActiveForm::begin(); 
      ?>
<div class="col-md-12">
  <div class="col-md-8 col-md-offset-2">
    <div style="min-height: 250px; height: 250px;" class="panel panel-default material-panel material-panel_primary">
      <h5 class="panel-heading material-panel__heading"></h5>
      <div id="body-form">  
        <div class="panel-body material-panel__body">
        <div style="display: none;">
         <?=  
           $form->field($modelPayment, 'id_payment_method')->radioList(['1'=>'Paypal <span class="fa fa-paypal"></span> <span class="fa fa-credit-card "></span> <span class="fa fa-cc-discover"></span> <span class="fa fa-cc-mastercard"></span>','2'=>'local Bank Transfers <span class="fa fa-bank"></span>',],[
            'id'=>'rad-method',
            'onchange'=>'
              var metod = $("#rad-method :radio:checked").val();
              if (metod == "") {
            $("#hasil-ajax").fadeOut(200);
            $("#hasil-ajax").html("");
            $("#div-submit").hide(300);


          }
          if (metod == 2) {
            $("#hasil-ajax").fadeOut(200);
            $("#hasil-ajax").html("");
            $("#div-submit").show(300);
            $("#harga-ext").hide(300);
            $("#harga-idr").show(300);
          }

          if (metod == 1) {
            $("#div-submit").hide(300);
            $("#harga-idr").hide(300);
            $("#harga-ext").show(300);
            $("#hasil-ajax").fadeIn(200);
            $.ajax({
                     url : "'.Url::to(["paypal"]).'",
                     type: "POST",
                     success: function (div) {
                     $("#hasil-ajax").html(div);

                     },
                   });
          }'
            ])->label(false) ?>
            </div>
    <center>
    <b style="display: none;" class="payment-harga" id="harga-ext" ><?= $modelPayment->currency." ".$modelPayment->total_payment ?></b>
    </center>   
    
</div>
    <center id="hasil-ajax"></center>
 </div>
      </div>
    </div>

    

    <?php ActiveForm::end(); ?>

</div>