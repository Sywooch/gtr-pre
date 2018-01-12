<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\components\BookingForm;
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
<div class="row">
  <div class="col-md-12">
      <div class="panel-group material-tabs-group">
      <h4 class="panel-heading">Booking Form</h4>
        <ul class="nav nav-tabs material-tabs material-tabs_primary">
          <li class="active"><a href="#fastboats" class="material-tabs__tab-link" data-toggle="tab">Fastboats</a></li>
          <li><a href="#hotels" class="material-tabs__tab-link" data-toggle="tab">Hotels</a></li>
        </ul>
        <div class="tab-content materail-tabs-content">
          <div class="tab-pane book-form book-form fade active in" id="fastboats">
            <div class="row"> 
              <?= BookingForm::widget(); ?>
            </div>
          </div>
          <div class="tab-pane book-form book-form fade" id="hotels">
           <div class="row"> 
            <?= BookingForm::widget(['formType' => BookingForm::HOTELS]); ?>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>
<div class="tcontent-view" id="scroller">

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
$this->registerJs("
  $('html, body').animate({
    scrollTop: $('#scroller').offset().top-100
  }, 1000); ", \yii\web\View::POS_READY);
?>