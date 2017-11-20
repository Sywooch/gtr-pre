<?php
use yii\helpers\Html;
use yii\helpers\Url;
 ?>


<!DOCTYPE html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
</head>
<body>
<?php
$total = $modelpembayaranPaypal->total_payment;
$currency = $modelpembayaranPaypal->currency;
$this->registerJs("

    paypal.Button.render({

            env: 'sandbox', // sandbox | production

            style: {
            label: 'pay',
            size:  'responsive', // small | medium | large | responsive
            shape: 'pill',   // pill | rect
            color: 'gold'   // gold | blue | silver | black
        },

            // PayPal Client IDs - replace with your own
            // Create a PayPal app: https://developer.paypal.com/developer/applications/create
            client: {
                sandbox:    'AZo8x_vbh0yEqwbRf6b_JkVmAA_DPkMwq9us4yuWsX1urrUmOcCcwu9N5vXwk1muqkvKITBMqjU9wVQK', //Sandbox akun mastuyink 94
               // production: 'AfJ2JcfQX0dwGOgVCYSqAm4V-6RHmN726doLwsA3vUMtgeCOJct59jMH9Z0PHyobxAUGIw_tDQJ0g1Qf' // ;live akun istana media
            },

            // Show the buyer a 'Pay Now' button in the checkout flow
            commit: true,

            // payment() is called when the button is clicked
            payment: function(data, actions) {

                // Make a call to the REST api to create the payment
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
                                        name: 'Payment Gilitranfers From : ".$modelpembayaranPaypal->name." | ".$modelpembayaranPaypal->email." | ".count($modelpembayaranPaypal->tBookings)." Trip',
                                        description: '".$modelpembayaranPaypal->token."',
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
                 alert(data);
             },

             onError: function (data, actions) {
                $('#rad-method').hide(100);
                     $('#body-form').html('<center><img src=../../loading.svg></center>');
                     $.ajax({
                     url : '".Url::to(["/payment/success"])."',
                     type: 'POST',
                   });
             }

        }, '#hasil-ajax');
");

?>
<?php /*echo Html::button('Test', ['class' => 'btn -lg btn-block btn btn-primary','onclick'=>"var mtk = '".$maskToken."';
                     $('#body-form').html('<center><img src=../../loading.svg></center>');

                     $.ajax({
                     url : '".Url::to(["success"])."',
                     type: 'POST',
                     async: 'true',
                     data: {umk: mtk},
                     success: function (div) {
                     alert('Payment Succesfull');
                     },
                   });"]);*/ ?>
<center><li style="display: none;" class="list-group-item" id="hasil-ajax"></li></center>
<center><div id="load-email"></div></center>
</body>

