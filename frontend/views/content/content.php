<?php

use yii\helpers\Html;
$this->title = 'Fast Boat Transfers Bali to Gili Island / Lombok / Nusa Lembongan';

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Fastboat from bali to gili island',
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => 'fastboat, fatboat bali to gili, transfers bali to gili',
]);

?>
<?php foreach ($listContent as $keyAr => $valContent): ?>
<div class=" col-sm-6 col-md-4">

    <div class="iam thumbnail material-card">
        <div class="material-card__header">
        <?= Html::img(['thumbnail','slug'=>$valContent->slug], ['height'=>'200px','width'=>'350px;','alt'=>'thumbnail'.$valContent->slug]); ?>
        </div>
    <div class="material-card__content">
        <h5 class="material-card__title"><?= Html::a($valContent->title, ['view','slug'=>$valContent->slug]); ?></h5>
        <p style="text-align: justify;"><?= substr($valContent->description, 0,100) ?></p>
    </div>

     <div class="material-card__footer">
        <?= Html::a('Read more', ['/content/view','slug'=>$valContent->slug,],['class'=>'btn material-btn material-btn_warning main-container__column material-btn_md btn-block']); ?>
     </div>
    </div>
</div>
<?php endforeach;	?>
<?php
$customCss = <<< SCRIPT
    .iam{
        min-height: 425px;
        height: auto;
    }
    .material-card__content{
        min-height: 140px;
        height: auto;
    }
SCRIPT;
$this->registerCss($customCss);
?>