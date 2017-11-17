<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Json;
use common\models\TVisitor;

$this->title = $content->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title); ?></h1>
<?=
$content->content;
?>

<?php $items = [
	[
        'url' => 'https://preview.ibb.co/mWpE3Q/2.jpg',
        'src' => 'https://preview.ibb.co/mWpE3Q/2.jpg',
        'options' => ['title' => 'Camposanto monumentale (inside)','class'=>'fastboat-galery','width'=>'30']
    ],
    [
        'url' => '/img/paypal.png',
        'src' => '/img/paypal.png',
        'options' => ['title' => 'Camposanto monumentale (inside)','class'=>'fastboat-galery','width'=>'30']
    ],
    [
        'url' => '/img/fastboat.png',
        'src' => '/img/fastboat.png',
        'options' => ['title' => 'Camposanto monumentale (inside)','class'=>'fastboat-galery','width'=>'30']
    ],
    [
        'url' => '/img/patagonia.jpg',
        'src' => '/img/patagonia.jpg',
        'options' => ['title' => 'Camposanto monumentale (inside)','class'=>'fastboat-galery','width'=>'30']
    ],
    [
        'url' => '/img/patagonia.jpg',
        'src' => '/img/patagonia.jpg',
        'options' => ['title' => 'Camposanto monumentale (inside)','class'=>'fastboat-galery','width'=>'30']
    ],
]
?>
<h1>Here</h1>
<div class="col-md-12">
<div class="row">
<hr>
<div class="gal">
<?= dosamigos\gallery\Gallery::widget(['items' => $items]);?>

</div></div></div>
<?php 
$customCss = <<< SCRIPT
.gal {
	
	
	-webkit-column-count: 3; /* Chrome, Safari, Opera */
    -moz-column-count: 3; /* Firefox */
    column-count: 3;
	  
	
	}	
	.gal img{ width: 100%; padding: 7px 0;}
@media (max-width: 500px) {
		
		.gal {
	
	
	-webkit-column-count: 1; /* Chrome, Safari, Opera */
    -moz-column-count: 1; /* Firefox */
    column-count: 1;
	  
	
	}
		
	}
SCRIPT;
$this->registerCss($customCss);
?>