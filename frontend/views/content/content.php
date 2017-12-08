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
<div class="col-sm-6 col-md-4 col-xs-12">

    <div class="div-card thumbnail material-card">
        <div class="material-card__header header-card">
        <?= Html::a(Html::img(['thumbnail','slug'=>$valContent->slug], ['class'=>'img','alt'=>'thumbnail'.$valContent->slug]),'/'.strtolower(str_replace([" ","/","&"], "-", $valContent->idTypeContent->type)).'/'.$valContent->slug); ?>
        </div>
    <div class="material-card__content">
        <h2 class="material-card__title"><?= Html::a($valContent->title, ['view','slug'=>$valContent->slug]); ?></h2>
        <p style="text-align: justify;"><?= substr($valContent->description, 0,100) ?></p>
    </div>

     <div class="material-card__footer">
        <?= Html::a('Read more', '/'.strtolower(str_replace([" ","/","&"], "-", $valContent->idTypeContent->type)).'/'.$valContent->slug,['class'=>'btn material-btn material-btn_warning main-container__column material-btn_md btn-block']); ?>
     </div>
    </div>
</div>
<?php endforeach;	?>
<?php
$customCss = <<< SCRIPT
    h2{
        font-size: 20px;
        font-weight: bold;
    }
    .material-card__header {
        text-align: center;
    }
    
    @media (max-width: 990px) {
        .img {
        min-height : 200px;
        max-height : 200px;
        height: auto;
        }
    }

    @media (min-width: 500px) {
        .img {
        width: auto;
        min-height : 200px;
        max-height : 200px;
        height: auto;
        }
    }

    .div-card{
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