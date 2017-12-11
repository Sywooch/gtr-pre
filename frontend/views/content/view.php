<?php

use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\TContent */

$this->title = $model['title'];
$this->params['breadcrumbs'][] = ['class'=>'material-breadcrumb__link','label' => $model['idTypeContent']['type'], 'url' => [strtolower(str_replace([" ","/","&"], "-", $model['idTypeContent']['type']))]];
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

<?= Html::img(['thumbnail','slug'=>$model['slug']], ['class' => 'img-responsive']); ?>
<?= 
$model['content'];
?>
<blockquote><p>Posted By: <?= $model['author0']['username'] ?></p><small>At : <?= date('d-m-Y H:i:s',date($model['updated_at'])) ?></small></blockquote>
<?php if(!empty($model['galeris'])): ?>
<?php foreach ($model['galeris'] as $key => $value) {
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
blockquote{
	font-size: 12px;;
}
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
<?php 

$this->registerJs('
$("table").addClass("table table-striped table-bordered table-hover");
$("iframe").removeAttr("style frameborder");
$("iframe").wrapAll("<div class=\'embed-responsive embed-responsive-16by9\'/>");
$("iframe").addClass("embed-responsive-item");
	', \yii\web\View::POS_READY);
?>