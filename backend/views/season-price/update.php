<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TSeasonPrice */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Tseason Price',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tseason Prices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tseason-price-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
