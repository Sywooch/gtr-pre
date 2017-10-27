<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Json;

$this->title = $content->title;
$this->params['breadcrumbs'][] = $this->title;
$userHost = Yii::$app->request->userAgent;
$userIP = Yii::$app->request->userIP;

echo "User Host = ".$userHost."<br>";
echo "IP = ".$userIP;
$info = file_get_contents('http://freegeoip.net/json/'.$userIP);
echo "This Visitor Info<br><br>";
$dec = Json::decode($info);
var_dump($dec);
?>
<h1><?= Html::encode($this->title); ?></h1>
<?php 
$content->content;
?>

