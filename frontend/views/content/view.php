<?php

use yii\helpers\Html;
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
var_dump($model);
?>
</div>
