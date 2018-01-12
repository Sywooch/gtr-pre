<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TSeasonPriceSet */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Season Price',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Season Price '), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tseason-price-set-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listCompany'=>$listCompany,
        'listRoute'=>$listRoute,
    ]) ?>

</div>
