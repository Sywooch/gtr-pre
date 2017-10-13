<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TShuttleArea */

$this->title = "Add Shuttle Area";
$this->params['breadcrumbs'][] = ['label' => 'Shuttle Area', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tshuttle-area-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listIsland' => $listIsland,
    ]) ?>

</div>
