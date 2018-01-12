<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TSeasonPrice */

$this->title = Yii::t('app', 'Add Season Price');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Season Price List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tseason-price-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'typeSeason' =>$typeSeason,
        'listTrip' =>$listTrip,
    ]) ?>

</div>
