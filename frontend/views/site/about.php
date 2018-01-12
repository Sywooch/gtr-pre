<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Json;


$this->title = $content->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title); ?></h1>
<?php
$str = '1_11-12-14';
$exp = explode('_', $str);
echo "ISland = ".$exp[0]."<br>";
$port = explode('-',$exp[1]);
print_r($port);

 ?>
<?=
$content->content;

$inputJson = '{
						    "va_numbers": [
						        {
						            "bank": "bca",
						            "va_number": "118423770021"
						        }
						    ],
						    "payment_amounts": [],
						    "transaction_time": "2018-01-05 15:46:14",
						    "gross_amount": "1360000.00",
						    "order_id": "ANY49X6RNRSIR2FXIYIZSSMG2",
						    "payment_type": "bank_transfer",
						    "signature_key": "6adb490923241370f9faa7ad118e443f0449c1986cd5973b9669d7445f8a044b856ffa6bef314881884e6aa0b2b9aa87a4f255a6a93cadc98870667c030252ec",
						    "status_code": "201",
						    "transaction_id": "c54273ba-d2a0-48d2-b836-ddec4db317bb",
						    "transaction_status": "pending",
						    "fraud_status": "accept",
						    "status_message": "Success, transaction is found"
						}';
			$inputArray = Json::decode($inputJson, $asArray = true);
?>
<?php 
$sigNature = $inputArray['signature_key'];

$orderId = $inputArray['order_id'];
$statusCode = $inputArray['status_code'];
$grossAmount = $inputArray['gross_amount'];
$serverKey = Yii::$app->params['MidtransServerKey'];
$input = $orderId.$statusCode.$grossAmount.$serverKey;
$signatureLocal = openssl_digest($input, 'sha512');
echo "INPUT: " , $input."<br/>";
echo "SIGNATURELOCAL : " , $signatureLocal."<br>";
echo "SIGNATUREMID : ", $inputArray['signature_key'];
?>
