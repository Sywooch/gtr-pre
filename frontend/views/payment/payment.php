<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\Url;
use kartik\widgets\AlertBlock;

/* @var $this yii\web\View */
/* @var $modelPayment app\models\TPembayaran */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Choose Payment Method';
$customCss = <<< SCRIPT
  .payment-harga{
    font-size: 20px;
    font-weight: bold;
  }
  .img-payment{
    max-height: 30px;
  }
SCRIPT;
$this->registerCss($customCss);
$modelPayment->id_payment_method = 1;
?>

<h1><?= Html::encode($this->title); ?></h1>
<div class="container">
<?= Html::beginForm(['/payment/index', 'id' => 'form-payment'], 'post') ?>
<div id="div-hidden" style="display: none;">
<?= Html::activeRadioList($modelPayment, 'id_payment_method', $listPaymentMethod,
  [
  'item' => function($index, $label, $name, $checked, $value) {
      $return  = '<div class="col-md-12">';
      $return .= '<label class="main-container__column material-radio-group material-radio-group_primary" for="radio-'.$value.'">';
      $return .= '<input type="radio" id="radio-'.$value.'" name="'.$name.'" value="'.$value.'" class="radio-payment material-radiobox">';
      $return .= '<span class="material-radio-group__element material-radio-group__check-radio"></span>
      <span class="material-radio-group__element material-radio-group__caption">';
      if ($value == 1) {
        $return .= 'Paypal ( Also Support VISA & Master Card )<img alt="payment-logo" class="img-payment img-responsive" src="/img/paypal.png">';
      }elseif ($value == 2) {
        $return .= 'BCA ( Also Support Klik BCA & m-BCA )<img alt="payment-logo" class="img-payment img-responsive" src="/img/bank-bca.png">';
      }elseif ($value == 3) {
        $return .= 'PERMATA BANK /  ATM BERSAMA ( Recomended if Your Bank Is Unavailable )<img alt="payment-logo" class="img-payment img-responsive" src="/img/atm-bersama.png">';
      }elseif ($value == 4) {
        $return .= 'Mandiri Bill Payment ( Also Support ATM Mandiri & Internet Banking Madiri )<img alt="payment-logo" class="img-payment img-responsive" src="/img/bank-mandiri.png">';
      }
      $return .= '</span></label></div>';
      return $return;
   }
  ]
); ?>
</div>
<div id="div-submit" class="col-md-12">
</div>

<?= Html::endForm() ?>
</div>
<?php 
$this->registerJs('
$("#div-submit").html("<center><img src=\'/loading.svg\'></center>");
  $(document).ready(function(){
    $("#radio-1").trigger("click");
    renderPaypal();
    $("#div-hidden").css("display","block");
  });
  
$(".radio-payment").on("change", function(){
    var metod = $("input[name=\'TPayment[id_payment_method]\']:checked").val();
          if (metod == 1) {
            renderPaypal();
          } else if (metod == 2 || metod == 3 || metod == 4 ) {
            if ( $("#submit-payment-button").length ) {
              
            } else {
              renderSubmitButton();
            }
          } else {
            $("#div-submit").html("");
          }
});
function renderSubmitButton(){
  $.ajax({
    url : "'.Url::to(["render-submit-button"]).'",
      type: "POST",
      data :{payment_idr: '.$modelPayment->total_payment_idr.'},
      success: function (div) {
        $("#div-submit").html(div);
      },
  });
}
function renderPaypal(){
  $.ajax({
    url : "'.Url::to(["render-paypal-button"]).'",
    type: "POST",
    success: function (div) {
      $("#div-submit").html(div);
    },
  });
}
', \yii\web\View::POS_READY);
$this->registerCss('
#div-submit{
  min-height: 125px;
}
  ');

?>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>