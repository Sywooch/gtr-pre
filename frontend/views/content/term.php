<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\models\TContent */

$this->title = $model['title'];
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
$model['content']
?>
</div>
