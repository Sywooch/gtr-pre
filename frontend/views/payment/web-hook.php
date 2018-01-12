<?php
use yii\helpers\Html;
use yii\helpers\Json;

$this->title = 'Fast Boat and Flight Transfers Bali to Gili Island / Lombok / Nusa Lembongan';
//$me = '{"nama":"mastuyink","Alamat":"banyuwangi"}';
$json = '{
    "scope": "https://uri.paypal.com/services/reporting/search/read https://api.paypal.com/v1/payments/.* https://uri.paypal.com/services/applications/webhooks openid",
    "nonce": "2017-11-21T07:34:08ZtkDT7vbpsqord0d6FydMiW9YsLC-O2BB6-M1x4FFzUM",
    "access_token": "A21AAHKjLvjo538sHFx_dlsU6UKMioKg6_U4lKYy6fDSOj3InVydviuAyUv0UibhJuUmZmXpdVo6NOet5xxlTtMFBurRK3w3w",
    "token_type": "Bearer",
    "app_id": "APP-80W284485P519543T",
    "expires_in": 31683
}';
?>

<h1>title</h1>

<?php 

$array = Json::decode($json, $asArray = true);

var_dump($array['access_token']);
 ?>