<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Json;
use common\models\TVisitor;

$this->title = $content->title;
$this->params['breadcrumbs'][] = $this->title;
$userAgent = Yii::$app->request->userAgent;
$userIP = Yii::$app->request->userIP;
$url = Yii::$app->request->url;
echo "User Host = ".$userAgent."<br>";
echo "IP = ".$userIP;
$info = file_get_contents('http://freegeoip.net/json/'.$userIP);
echo "This Visitor Info<br><br>";
$infoArray = Json::decode($info);
var_dump($infoArray);
echo "<br><br>URL = ".$url;
$modelVisitor = new TVisitor();
$modelVisitor->ip = $infoArray['ip'];
$modelVisitor->country = $infoArray['country_name'];
// /$modelVisitor->
?>
<h1><?= Html::encode($this->title); ?></h1>
<?php 
$content->content;
?>

