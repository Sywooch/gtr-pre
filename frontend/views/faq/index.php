<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
$this->title = 'FAQ';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="panel-group material-accordion material-accordion_warning" id="accordion2">
<?php if (!empty($content)):?>
<?php foreach ($content as $key => $value): ?>
 <div class="panel panel-default material-accordion__panel material-accordion__panel">
        <div class="panel-heading material-accordion__heading" id="heading<?= $value->title ?>">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion2" href="#<?= $value->id?>" class="material-accordion__title"><?= $value->title ?></a>
          </h4>
        </div>
        <div id="<?= $value->id?>" class="panel-collapse collapse material-accordion__collapse">
          <div style="min-height: 350px;" class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <?= $value->content ?>
              </div>
            </div>
          </div>
        </div>
</div>
      
<?php endforeach; ?>
<?php else: ?>
  <h1>FAQ Unavaible</h1>
<?php endif; ?>
 </div> 
