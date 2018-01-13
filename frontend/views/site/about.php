<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Json;


$this->title = $content->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title); ?></h1>
<?=
$content->content;
?>
