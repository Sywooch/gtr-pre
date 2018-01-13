<?php
use yii\helpers\Url;
 ?>

<?php


$total = $modelpembayaranPaypal['total_payment'];
$currency = $modelpembayaranPaypal['currency'];

$this->registerJs("

    paypal.Button.render({

            env: '".Yii::$app->params['PaypalEnv']."', 

            style: {
            label: 'pay',
            size:  'responsive', // small | medium | large | responsive
            shape: 'pill',   // pill | rect
            color: 'gold'   // gold | blue | silver | black
        },
            client: {
                ".Yii::$app->params['PaypalEnv'].":    '".Yii::$app->params['PaypalClientKey']."', 
            },
            commit: true,
            payment: function(data, actions) {
                return actions.payment.create({
                    payment: {
                        transactions: [
                            {
                                amount: 
                                 {
                                    total: '".$total."',
                                    currency: '".$currency."',
                                 },
                                item_list: {
                                        items: [
                                        {
                                        name: '".$message.$modelpembayaranPaypal['name']." | ".$modelpembayaranPaypal['email']."',
                                        description: '".$modelpembayaranPaypal['token']."',
                                        quantity: '1',
                                        price: '".$total."',
                                        currency: '".$currency."'
                                        }
                                        ]
                                }
                            }
                        ]
                    }
                });
            },


            onAuthorize: function(data, actions) {
                // Make a call to the REST api to execute the payment
                return actions.payment.execute().then(function(data) {
                    $('#rad-method').hide(100);
                     $('#body-form').html('<center><img src=../../loading.svg></center>');
                     $.ajax({
                     url : '".Url::to(["/payment/success"])."',
                     type: 'POST',
                     async: 'true',
                     data: {umk: data},
                     success: function (div) {
                        alert('Payment Succesfull');
                     },
                   });

                });
            },

             onCancel: function (data, actions) {
                 alert('Payment Cancelled');
             },

             onError: function (data, actions) {
                $('#rad-method').hide(100);
                     $('#body-form').html('<center><img src=../../loading.svg></center>');
                     $.ajax({
                     url : '".Url::to(["/payment/error"])."',
                     type: 'POST',
                   });
             }

        }, '#hasil-ajax');
");

?>
<center>
    <div class="col-md-12"><b class="payment-harga"><?= $currency." ".number_format($total,0) ?></b></div>
    <div class="col-md-12" id="hasil-ajax"></div>
</center>



