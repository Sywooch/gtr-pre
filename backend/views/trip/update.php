<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TTrip */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Trip',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Trip List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="ttrip-update">

    <?= $this->render('_update', [
        'model' => $model,
        'listBoat'=>$listBoat,
        'listCompany'=>$listCompany,
        'listRoute'=>$listRoute,
    ]) ?>

</div>
