<?php

use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\TContent */

$this->title = $model['title'];
$this->params['breadcrumbs'][] = ['label' => $model['idTypeContent']['type'], 'url' => ['content/'.strtolower(str_replace([" ","/","&"], "-", $model['idTypeContent']['type']))]];
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag([
    'name' => 'description',
    'content' => $model['description'],
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $model['keywords'],
]);

?>
<div class="tcontent-view">

    <h1><?= Html::encode($this->title) ?></h1>
<?= 
$model['content'];
?>
<?php if(!empty($model['galeris'])): ?>
<?php

foreach ($model['galeris'] as $key => $value) {
	$image[]=[
		       // 'url' => Url::to(['galery','id'=>$value['id']]),
		        'src' => Url::to(['galery','id'=>$value['id']]),
		        'alt'=>'image',
		        'options' => ['title' => $value['name']]
    		];
}
?>
<h2>Galery</h2>
<div class="col-md-12">
<div class="row">
<hr>
<div class="gal">
<?= dosamigos\gallery\Gallery::widget(['items' => $image]);?>

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
<?php endif; ?>
</div>
