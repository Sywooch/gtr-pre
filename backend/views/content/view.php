<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<h1><?= Html::encode($this->title) ?></h1>
<?= $model->content ?>
<?php if(isset($model->galeris)): ?>
<?php

foreach ($model->galeris as $key => $value) {
	$image[]=[
		       // 'url' => Url::to(['galery','id'=>$value['id']]),
		        'src' => Url::to(['galery','id'=>$value->id]),
		        'alt'=>'image',
		        'options' => ['title' => $value->name]
    		];
}
?>
<h2>Galery</h2>
<hr>
<div class="gal">
<?= dosamigos\gallery\Gallery::widget(['items' => $image]);?>

</div>
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
<?php endif; ?>